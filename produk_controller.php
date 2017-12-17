<?php

(defined('BASEPATH')) OR exit('No direct script access allowed');

/**
 * Description of site
 *
 * @author http://www.roytuts.com just check change
 */
class produk_controller extends MX_Controller  {
		var $data = array();
	function __construct()
	{
		$this->load->model('product_model');
		$this->load->helper('url');
	}


	public function index(){
		
		$this->data['get_produk'] = $this->product_model->get_product();
		$this->ciparser->new_parse("templete_admin", "modules_admin", "produk/Produk_view",$this->data);
	}
	public function add_produk(){
		$a = $this->uri->segment_array();
        $id = end($a);
		if ($this->input->server('REQUEST_METHOD') == 'POST') {
			$this->form_validation->set_error_delimiters('','');;
			$this->form_validation->set_rules('nama','Nama Produk','required');
			$this->form_validation->set_rules('desc','Deskripsi Produk','required');
			$this->form_validation->set_rules('harga','Harga Produk','required|trim|numeric');
			$this->form_validation->set_rules('harga_khusus','Harga Khusus Produk','numeric');
			if ($this->form_validation->run() == 'true') {
				$ret['state'] = 1;
				$data['nm_produk'] = $this->input->post('nama');
				$data['price_produk'] = $this->input->post('harga');
				$data['desc_produk'] = $this->input->post('desc');

				if (!is_numeric($id)) {
					
					$imagename = $_FILES['gambar']['name'];
					$ext = strtolower($this->_getExtension($imagename));
					$config['upload_path']          =  FCPATH."uploads/product/thumb/";
		            $config['allowed_types']        = 'gif|jpg|png';
		            $config['max_size']             = 2048;
		            $config['max_width']            = 1024;
		            $config['file_name']			= time().".".$ext;

		            $this->load->library('upload', $config);

		            if ( ! $this->upload->do_upload('gambar'))
		            {
		                    $error = array('error' => $this->upload->display_errors());
							$ret['state'] = 0;
		                    $ret['notif'] = $error;
		                    echo json_encode($ret);
		                    exit();
		            }
		            else
		            {
		                    $upload_data = $this->upload->data();

		                    $config['image_library'] = 'gd2';
							$config['source_image'] = './uploads/product/thumb/'.$upload_data['file_name'];
							$config['create_thumb'] = FALSE;
							$config['maintain_ratio'] = TRUE;
							$config['width']         = 407;

							$this->load->library('image_lib', $config);

							$this->image_lib->resize();
		            }
                        
						if ($sql = $this->db->insert('tb_produk',$data)) {
							$product['id_produk'] = $this->db->insert_id();
							$data_image['image_name'] = $upload_data['file_name'];
							$data_image['id_photo_produk'] = $product['id_produk'];
							$this->db->insert('tb_photo_produk',$data_image);
		                    if($this->input->post('harga_khusus') != ''){
			                    $khusus['harga'] = $this->input->post('harga_khusus');
			                    $khusus['id_produk_ref'] = $product['id_produk'];
		                    	$this->db->insert('tb_harga_khusus',$khusus);
		                    }
							$ret['status'] = 1;
							$ret['text'] = 'Insert Data Berhasil';
						}else{
							$ret['status'] = 0;
						}
					// }
				}else{
					if(isset($_FILES["gambar"]["name"])) {
						/*print_r($_FILES["gambar"]);
						print_r('adasd');
						return false;*/
						$imagename = $_FILES['gambar']['name'];
						$ext = strtolower($this->_getExtension($imagename));

						$config['upload_path']          =  FCPATH."uploads/product/thumb/";
			            $config['allowed_types']        = 'gif|jpg|png';
			            $config['max_size']             = 2048;
			            $config['max_width']            = 1024;
			            $config['file_name']			= time().".".$ext;

			            $this->load->library('upload', $config);

			            if ( ! $this->upload->do_upload('gambar'))
			            {
			                    $error = array('error' => $this->upload->display_errors());
			                    $ret['state'] = 0;
			                    $ret['notif'] = $error;
			                    echo json_encode($ret);
			                    exit();
			            }
			            else
			            {
			                    $upload_data = $this->upload->data();

			                    $config['image_library'] = 'gd2';
								$config['source_image'] = './uploads/product/thumb/'.$upload_data['file_name'];
								$config['create_thumb'] = FALSE;
								$config['maintain_ratio'] = TRUE;
								$config['width']         = 407;

								$this->load->library('image_lib', $config);

								$this->image_lib->resize();
			            }
	                        $data['photo_produk'] = $upload_data['file_name'];
							$upd = "SELECT price_produk, photo_produk FROM tb_produk WHERE id_produk = ?";
							$ret_upd = $this->db->query($upd,$id)->row_array();
							if ($ret_upd['price_produk'] != $data['price_produk']) {
								$product['id_produk'] = $id;
								$product['perubahan_harga'] = date('Y-m-d H:i:s');
								$product['harga_lama'] = $ret_upd['price_produk'];
								$ins = $this->db->insert('tb_histori_harga',$product);
							}
							$hk = "SELECT * FROM tb_harga_khusus WHERE id_produk_ref = ?";
							$ret_hk = $this->db->query($hk,$id)->row_array();
							if ($ret_hk['harga'] == '') {
								if ($ret_hk['harga'] != $this->input->post('harga_khusus')) {
									$khusus['harga'] = $this->input->post('harga_khusus');
				                    $khusus['id_produk_ref'] = $id;
			                    	$this->db->insert('tb_harga_khusus',$khusus);
								}
							}else{
								$s_k['id_produk_ref'] = $id;
								$khusus['harga'] = $this->input->post('harga_khusus');
			                    $khusus['id_produk_ref'] = $id;
		                    	if($khusus['harga'] != $ret_hk['harga']){
									$product_hk['id_harga_khusus_ref'] = $ret_hk['id_harga_khusus'];
									$product_hk['perubahan_harga'] = date('Y-m-d H:i:s');
									$product_hk['harga'] = $ret_hk['harga'];
									$ins_hk = $this->db->insert('tb_histori_harga_khusus',$product_hk);
		                    	}
		                    	$this->db->update('tb_harga_khusus',$khusus,$s_k);
							}
							$target_dir = FCPATH."uploads/product/thumb/";
							if(file_exists($target_dir.$ret_upd['photo_produk'])){
                        		@chmod($target_dir.$ret_upd['photo_produk'], 0777);
    							unlink($target_dir.$ret_upd['photo_produk']);
							}
							$search['id_produk'] = $id;
							if ($sql = $this->db->update('tb_produk',$data,$search)) {
								$ret['status'] = 1;
								$ret['text'] = 'Update Data Berhasil';
							}else{
								$ret['text'] = 'Update Data Gagal';
								$ret['status'] = 0;
							}
						// }
					}else{
						$upd = "SELECT price_produk, photo_produk FROM tb_produk WHERE id_produk = ?";
						$ret_upd = $this->db->query($upd,$id)->row_array();
						if ($ret_upd['price_produk'] != $data['price_produk']) {
							$product['id_produk'] = $id;
							$product['perubahan_harga'] = date('Y-m-d H:i:s');
							$product['harga_lama'] = $ret_upd['price_produk'];
							$ins = $this->db->insert('tb_histori_harga',$product);
						}
						$hk = "SELECT * FROM tb_harga_khusus WHERE id_produk_ref = ?";
						$ret_hk = $this->db->query($hk,$id)->row_array();
						if ($ret_hk['harga'] == '') {
							if ($ret_hk['harga'] != $this->input->post('harga_khusus')) {
								$khusus['harga'] = $this->input->post('harga_khusus');
			                    $khusus['id_produk_ref'] = $id;
		                    	$this->db->insert('tb_harga_khusus',$khusus);
							}
						}else{
							$s_k['id_produk_ref'] = $id;
							$khusus['harga'] = $this->input->post('harga_khusus');
		                    $khusus['id_produk_ref'] = $id;
	                    	if($khusus['harga'] != $ret_hk['harga']){
								$product_hk['id_harga_khusus_ref'] = $ret_hk['id_harga_khusus'];
								$product_hk['perubahan_harga'] = date('Y-m-d H:i:s');
								$product_hk['harga'] = $ret_hk['harga'];
								$ins_hk = $this->db->insert('tb_histori_harga_khusus',$product_hk);
	                    	}
	                    	$this->db->update('tb_harga_khusus',$khusus,$s_k);
						}
						$search['id_produk'] = $id;
						if ($sql = $this->db->update('tb_produk',$data,$search)) {
							$ret['status'] = 1;
							$ret['text'] = 'Update Data Berhasil';
						}else{
							$ret['text'] = 'Update Data Gagal';
							$ret['status'] = 0;
						}
					}
				}
			}else{
				$ret['state'] = 0;
			}
			$ret['notif']['nama'] = form_error('nama');
			$ret['notif']['harga'] = form_error('harga');
			$ret['notif']['desc'] = form_error('desc');

			echo json_encode($ret);
			exit();
		}
		$this->data['id'] = $id;
		$this->data['row_produk'] = $this->product_model->row_produk($id);
		$this->ciparser->new_parse("templete_admin", "modules_admin", "produk/add_produk_view",$this->data);
	}
	public function delete(){
			$ret['state'] = 0;
			$id['id_produk'] = $this->input->post('id');
			$were = "SELECT photo_produk FROM tb_produk where id_produk = ".$this->input->post('id')."";
        	$getGambar = $this->db->query($were)->row_array();
        	$target_dir = FCPATH."uploads/product/thumb/";
    		if(file_exists($target_dir.$getGambar['photo_produk'])){
        		@chmod($target_dir.$getGambar['photo_produk'], 0777);
				unlink($target_dir.$getGambar['photo_produk']);
			}
			$trunk = "DELETE FROM tb_histori_harga WHERE id_produk = ?";
			if($this->db->query($trunk,$this->input->post('id'))){
				$ret['status'] = 1;
			}
			if ($this->db->delete('tb_produk',$id)) {
				$ret['state'] = 1;
			}
			echo json_encode($ret);
			exit();
		}
	function _getExtension($str){
        $i = strrpos($str,".");
        if (!$i){
            return "";
        }   
        $l = strlen($str) - $i;
        $ext = substr($str,$i+1,$l);
        return $ext;
    }

	function _compressImage($ext,$uploadedfile,$target_dir_thumb,$actual_image_name,$newwidth){

        if($ext == "jpg" || $ext == "jpeg" ){
            $src = imagecreatefromjpeg($uploadedfile);
        }else if($ext == "png"){
            $src = imagecreatefrompng($uploadedfile);
            $background = imagecolorallocatealpha($src,0,0,0,127);
            imagecolortransparent($src, $background);
        }else if($ext == "gif"){
            $src = imagecreatefromgif($uploadedfile);
        }else{
            $src = imagecreatefrombmp($uploadedfile);
        }

        //$thumbs_dir = $target_dir."thumbs/";    
        list($width,$height) = getimagesize($uploadedfile);
        $newheight = ($height/$width)*$newwidth;
        $tmp = imagecreatetruecolor($newwidth,$newheight);
        imagecopyresampled($tmp,$src,0,0,0,0,$newwidth,$newheight,$width,$height);
        imagealphablending($tmp, false);
		imagesavealpha($tmp,true);
        $filename = $target_dir_thumb.$actual_image_name; //PixelSize_TimeStamp.jpg
        imagejpeg($tmp,$filename,100);
        imagedestroy($tmp);
        header("Content-type: image/".$ext);
        return $filename;
    }

    public function view_photo(){
    	$id['id_produk'] = $this->input->post('id');
    	$sql = "SELECT * FROM tb_produk WHERE id_produk = ?";
    	$ret = $this->db->query($sql,$id)->row_array();
    	$tr['title'] = $ret['nm_produk'];
    	$tr['gambar'] = $ret['photo_produk'];
    	echo json_encode($tr);
    	exit();
    }

}
