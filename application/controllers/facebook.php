<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class facebook extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -  
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
		$this->load->view('main');
	}
	public function direction()
	{
		$this->load->view('direction');
	}
	public function addfriends()
	{
		$this->load->view('addfriends');
	}
        public function addmsg()
        {
            if($_POST)
            {
                $content = $_POST['content'];
                $this->db->insert("fb_msg",array("content"=>$content,"fb_id"=>  $this->session->userdata("fb_id")));
                redirect('facebook/groupindex');
            }
            $this->load->view('addmsg');
        }
        public function delmsg()
        {
            $msg_id = $this->uri->segment(3);
            $this->db->delete('fb_msg',array('id' => $msg_id));
            
            redirect('facebook/groupindex');
        }
        public function groupindex()
	{
            //获取我的社团
            $links = "https://graph.facebook.com/".$this->session->userdata('fb_id')."/groups?method=GET&format=json&access_token=".$this->session->userdata('access_token');
            $fb_data_json = file_get_contents($links);
            $fb_data =  json_decode($fb_data_json,TRUE);
            $data['groups']=$fb_data;
            //更新当前用户的社团
            foreach($fb_data['data'] as $val){
                $this->insertnewgroup($val);
            }
//                print_r($fb_data);

            //获取当前用户的消息列表
            $query = $this->db->get_where('fb_msg',array('fb_id'=>$this->session->userdata("fb_id")));
            $data['my_msg']= $query->result_array();
            $this->load->view('groupindex',$data);
	}
        private function insertnewgroup($group)
        {
            //检查数据库是否已经存在，否，插入
            $query = $this->db->get_where('fb_groups',array("fb_id"=>  $this->session->userdata("fb_id"),"groupid"=>$group['id']));
            if($query->num_rows()>0)
            {
                $this->db->where("groupid",$group['id']);
                $this->db->update("fb_groups",array("fb_id"=>  $this->session->userdata("fb_id"),"groupname"=>$group['name']));
            }
            else
            {
                $this->db->insert("fb_groups",array("fb_id"=>  $this->session->userdata("fb_id"),"groupid"=>$group['id'],"groupname"=>$group['name']));
            }
        }

        public function publishtogroup()
        {
            /**
             * 1. 先找出有多少的社团，id
             * 2. 再找出属于当前用户的msg
             * 3. 发送消息，循环
             */
            $query_group = $this->db->get_where('fb_groups',array("fb_id"=>  $this->session->userdata("fb_id")));
            if($query_group->num_rows()>0)
            {
                $query_msg = $this->db->get_where('fb_msg',array('fb_id'=>$this->session->userdata("fb_id")));
                if($query_msg->num_rows()>0)
                {
                    $ch = curl_init();
                    $timeout = 5;  

                    $array_msg = $query_msg->result_array();
//                    $content_tosend = 
                    foreach ($query_group->result_array() as $k=>$v)
                    {
                        $message = $array_msg[array_rand($array_msg)]['content'];
                        $sendout= (base_url()."oauth/process.php?usergroups=".$v['groupid']."&message=".urlencode($message));
                        echo $sendout;
                        $sendout=file_get_contents("http://facebook.iyanlang.com/oauth/process.php?usergroups=468600013226142&message=Choose");
                        echo $sendout;
//                        http://facebook.iyanlang.com/oauth/process.php?usergroups=260183137455047&message=teingggg
//                        
                        //TODO 还没完成

                    }
                    
                   
                }
            }
           
            
        }

        

        public function suggestto()
	{
            //获取我的朋友列表
            $links = "https://graph.facebook.com/".$this->session->userdata('fb_id')."/friends?method=GET&format=json&access_token=".$this->session->userdata('access_token');
                $fb_data_json = file_get_contents($links);
                $fb_data =  json_decode($fb_data_json,TRUE);
                $data['friends']= $fb_data;
                //更新当前用户的好友
                foreach($fb_data['data'] as $val){
                    $this->insertnewfriend($val);
                }
//                print_r($fb_data);
		$this->load->view('suggestto',$data);
	}
        
        
        private function insertnewfriend($user)
        {
            //检查数据库是否已经存在，否，插入
            $this->db->LIKE("belongto_fb_id",$this->session->userdata("fb_id"));
            $this->db->LIKE("fb_id",$user['id']);
            $query = $this->db->get_where('fb_members',array());
            if( $query->num_rows()==0) print_r (array("belongto_fb_id"=>$this->session->userdata("fb_id"),"fb_id"=>$user['id']));
            if($query->num_rows()>0)
            {
//                $this->db->where("fb_id",$user['id']);
//                $this->db->update("fb_members",array("fb_name"=>$user['name']));
            }
            else
            {
                $this->db->insert("fb_members",array("belongto_fb_id"=>$this->session->userdata("fb_id"),"fb_id"=>$user['id'],"fb_name"=>$user['name'],"isfriend"=>1));
            }
        }
        
        public function token()
        {
//            $data['code']=  $this->uri->segment(3);
//            $token = $this->uri->segment(4);
            $data['token']=$this->uri->segment(3);
            $data['fbid']=  $this->uri->segment(4);
            
            //检查fbid是否存在，存在则更新，不存在则插入
            $query = $this->db->get_where('fb_sys_users',array("fb_id"=>$data['fbid']));
            
            if($query->num_rows()>0)
            {
                $this->db->where('fb_id',$data['fbid']);
                $this->db->update("fb_sys_users",array('access_token'=>$data['token']));
            }
            else
            {
                $links = "https://graph.facebook.com/".$data["fbid"];
                $fb_data_json = file_get_contents($links);
                $fb_data =  json_decode($fb_data_json);
                $insertdata=array("fb_id"=>$fb_data->id,"fb_name"=>$fb_data->name,"fb_username"=>$fb_data->username,"access_token"=>$data['token'],"link"=>$fb_data->link);
                $this->db->insert("fb_sys_users",$insertdata);
            }
            //写入到session中去
            $query = $this->db->get_where('fb_sys_users',array("fb_id"=>$data['fbid']));
            $query = $query->row_array();
            $this->session->set_userdata($query);
//            print_r($this->session->all_userdata());
            $this->load->view('main',$data);
            
        }
	
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */