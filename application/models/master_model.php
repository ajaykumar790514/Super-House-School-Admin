<?php

defined('BASEPATH') OR exit('No direct script access allowed');

#[\AllowDynamicProperties]

class master_model extends CI_Model

{

 

     // BY AJAY KUMAR

      /*

     *  Select Records From Table

     */

    public function Select($Table, $Fields = '*', $Where = 1)

    {

        /*

         *  Select Fields

         */

        if ($Fields != '*') {

            $this->db->select($Fields);

        }

        /*

         *  IF Found Any Condition

         */

        if ($Where != 1) {

            $this->db->where($Where);

        }

        /*

         * Select Table

         */

        $query = $this->db->get($Table);



        /*

         * Fetch Records

         */



        return $query->result();

    }

   /*

     * Count No Rows in Table

     */

 

    public function Counter($Table, $Where = 1)

    {

        $rows = $this->Select($Table, '*', $Where);



        return count($rows);

    }

        function getRow($tb,$data=0) {



        if ($data==0) {

            if($data=$this->db->get($tb)->row()){

                return $data;

            }else {

                return false;

            }

        }elseif(is_array($data)) {

            if($data=$this->db->get_where($tb, $data)){

                return $data->row();

            }else {

                return false;

            }

        }else {

            if($data=$this->db->get_where($tb,array('id'=>$data))){

                return $data->row();

            }else {

                return false;

            }

        }



    }

   





    function Save($tb,$data){

        if($this->db->insert($tb,$data)){

            return $this->db->insert_id();

        }

        return false; 

    }

    function Update($tb,$data,$cond) {

        $this->db->where($cond);

        if($this->db->update($tb,$data)) {

            return true;

        }

        return false;

    }

    function _delete($tb,$data) {

        if (is_array($data)){

            $this->db->where($data);

            if($this->db->update($tb,['is_deleted'=>'DELETED'])){

                return true;

            }

        }

        else{

            $this->db->where('id',$data);

            if($this->db->update($tb,['is_deleted'=>'DELETED'])){

                return true;

            }

        }

        return false;

    }

     

    //Category

public function add_category($data)

    {

        $config['file_name'] = rand(10000, 10000000000);

        $config['upload_path'] = UPLOAD_PATH.'category/';

        $config['allowed_types'] = 'jpg|jpeg|png|gif|pdf|webp|svg';

        $this->load->library('upload', $config);

        $this->upload->initialize($config);



        if (!empty($_FILES['icon']['name'])) {

            // $fileinfo = @getimagesize($_FILES["icon"]["tmp_name"]);

            // $width = $fileinfo[0];

            // $height = $fileinfo[1];



            //upload images

            $_FILES['icons']['name'] = $_FILES['icon']['name'];

            $_FILES['icons']['type'] = $_FILES['icon']['type'];

            $_FILES['icons']['tmp_name'] = $_FILES['icon']['tmp_name'];

            $_FILES['icons']['size'] = $_FILES['icon']['size'];

            $_FILES['icons']['error'] = $_FILES['icon']['error'];



            if ($this->upload->do_upload('icons')) {

        

           

                $image_data = $this->upload->data();

                

                if($_FILES['icons']['type']=='image/webp')

                {

                        $img =  imagecreatefromwebp(UPLOAD_PATH.'category/'. $image_data['file_name']);

//                        imagepalettetotruecolor($img);

//                        imagealphablending($img, true);

//                        imagesavealpha($img, true);

                        imagewebp($img, UPLOAD_PATH.'category/thumbnail/'. $image_data['file_name'], 80);

                        imagedestroy($img);

                }

                else

                {

                        

                        $config2 = array(

                            'image_library' => 'gd2', //get original image

                            'source_image' =>   UPLOAD_PATH.'category/'. $image_data['file_name'],

                            'width' => 640,

                            'height' => 360,

                            'new_image' =>  UPLOAD_PATH.'category/thumbnail/'. $image_data['file_name'],

        

                        );

                        $this->load->library('image_lib');

                        $this->image_lib->initialize($config2);

                        $this->image_lib->resize();

                        $this->image_lib->clear();

                }

                $fileName = "category/" . $image_data['file_name'];

                $fileName2 = "category/thumbnail/" . $image_data['file_name'];

            }

            $data['icon'] = $fileName;

            $data['thumbnail'] = $fileName2;

        } else {

            $data['icon'] = "";

        }

        if (!empty($fileName))

        {  

            return $this->db->insert('products_category', $data);

        }

    }

    

    

    public function edit_category($data,$id)

    {

        $config['file_name'] = rand(10000, 10000000000);

        $config['upload_path'] = UPLOAD_PATH.'category/';

        $config['allowed_types'] = 'jpg|jpeg|png|gif|pdf|webp|svg';

        $this->load->library('upload', $config);

        $this->upload->initialize($config);



        if (!empty($_FILES['icon']['name'])) {

            //upload images

            $_FILES['icons']['name'] = $_FILES['icon']['name'];

            $_FILES['icons']['type'] = $_FILES['icon']['type'];

            $_FILES['icons']['tmp_name'] = $_FILES['icon']['tmp_name'];

            $_FILES['icons']['size'] = $_FILES['icon']['size'];

            $_FILES['icons']['error'] = $_FILES['icon']['error'];



            if ($this->upload->do_upload('icons')) {

        

                $image_data = $this->upload->data();

                

                if($_FILES['icons']['type']=='image/webp')

                {

                        $img =  imagecreatefromwebp(UPLOAD_PATH.'category/'. $image_data['file_name']);

                        imagepalettetotruecolor($img);

//                        imagealphablending($img, true);

//                        imagesavealpha($img, true);

                        imagewebp($img, UPLOAD_PATH.'category/thumbnail/'. $image_data['file_name']);

                        imagedestroy($img);

                }

                else

                {

                        

                        $config2 = array(

                            'image_library' => 'gd2', //get original image

                            'source_image' =>   UPLOAD_PATH.'category/'. $image_data['file_name'],

                            'width' => 640,

                            'height' => 360,

                            'new_image' =>  UPLOAD_PATH.'category/thumbnail/'. $image_data['file_name'],

        

                        );

                        $this->load->library('image_lib');

                        $this->image_lib->initialize($config2);

                        $this->image_lib->resize();

                        $this->image_lib->clear();

                }

                $fileName = "category/" . $image_data['file_name'];

                $fileName2 = "category/thumbnail/" . $image_data['file_name'];

            }

            $data['icon'] = $fileName;

            $data['thumbnail'] = $fileName2;

            



            if (!empty($fileName) && !empty($fileName2))    

            {

                $data1['cat_images'] = $this->master_model->get_row_data1('products_category','id',$id);

                $cat_image = @ltrim($data1['cat_images']->icon, '/');

                $cat_thumb = @ltrim($data1['cat_images']->thumbnail, '/');

                if(is_file(DELETE_PATH.$cat_image))

                {

                    unlink(DELETE_PATH.$cat_image);

                }

                if(is_file(DELETE_PATH.$cat_thumb))

                {

                    unlink(DELETE_PATH.$cat_thumb); 

                }

            }

        }



            return $this->db->where('id', $id)->update('products_category', $data); 



        

    }

    function getData($tb, $data = 0, $order = null, $order_by = null, $limit = null, $start = null)

    {



        if ($order != null) {

            if ($order_by != null) {

                $this->db->order_by($order_by, $order);

            } else {

                $this->db->order_by('id', $order);

            }

        }



        if ($limit != null) {

            $this->db->limit($limit, $start);

        }



        if ($data == 0 or $data == null) {

            return $this->db->get($tb)->result();

        }

        if (@$data['search']) {

            $search = $data['search'];

            unset($data['search']);

        }

        return $this->db->get_where($tb, $data)->result();

    }

    

    //Product

    public function get_parent_category()

    {

        $query = $this->db->get_where('products_category', ['is_deleted' => 'NOT_DELETED', 'is_parent' => '0', 'active' => '1']);

        return $query->result();

    }

    public function get_parent_category_aps($APS)

    {

        $query = $this->db->get_where('products_category', ['is_deleted' => 'NOT_DELETED', 'is_parent' => '0', 'active' => '1','group_id'=>$APS]);

        return $query->result();

    }

    public function get_parent_category_dps($DPS)

    {

        $query = $this->db->get_where('products_category', ['is_deleted' => 'NOT_DELETED', 'is_parent' => '0', 'active' => '1','group_id'=>$DPS]);

        return $query->result();

    }
    public function get_parent_cat_akids($AKids)

    {

        $query = $this->db->get_where('products_category', ['is_deleted' => 'NOT_DELETED', 'is_parent' => '0', 'active' => '1','group_id'=>$AKids]);

        return $query->result();

    }
    

    public function get_parent_category_group($group)

    {

        $query = $this->db->get_where('products_category', ['is_deleted' => 'NOT_DELETED', 'is_parent' => '0', 'active' => '1','group_id'=>$group]);

        return $query->result();

    }

        public function add_duplicate_product($data,$duplicate_id)

    {

        $imageCount = count($_FILES['img']['name']);

        if (!empty($imageCount)) {

            

            for ($i = 0; $i < $imageCount; $i++) {

                

                $config['file_name'] = date('Ymd') . rand(1000, 1000000);

                $config['upload_path'] = UPLOAD_PATH.'product/';

                $config['allowed_types'] = 'jpg|jpeg|png|gif|webp|svg';

                $this->load->library('upload', $config);

                $this->upload->initialize($config);

                $_FILES['imgs']['name'] = $_FILES['img']['name'][$i];

                $_FILES['imgs']['type'] = $_FILES['img']['type'][$i];

                $_FILES['imgs']['tmp_name'] = $_FILES['img']['tmp_name'][$i];

                $_FILES['imgs']['size'] = $_FILES['img']['size'][$i];

                $_FILES['imgs']['error'] = $_FILES['img']['error'][$i];

                if ($this->upload->do_upload('imgs')) {

                 

                    $imageData = $this->upload->data();

                     if($_FILES['imgs']['type']=='image/webp')

                        {

                                $img =  imagecreatefromwebp(UPLOAD_PATH.'product/'. $imageData['file_name']);



                                imagewebp($img, UPLOAD_PATH.'product/thumbnail/'. $imageData['file_name'],80);

                                imagedestroy($img);

                        }

                        else

                        {

                            $config2 = array(

                                'image_library' => 'gd2', //get original image

                                'source_image' =>   UPLOAD_PATH.'product/'. $imageData['file_name'],

                                'width' => 640,

                                'height' => 360,

                                'new_image' =>  UPLOAD_PATH.'product/thumbnail/'. $imageData['file_name'],

                            );

                            $this->load->library('image_lib');

                            $this->image_lib->initialize($config2);

                            $this->image_lib->resize();

                            $this->image_lib->clear();

                        }



                    $images[] = "product/" . $imageData['file_name'];

                    $images2[] = "product/thumbnail/" . $imageData['file_name'];

                }

            }

        }

        

        if (!empty($images))

        {     

            $this->db->insert('products_subcategory', $data);

            $insert_id = $this->db->insert_id();

            foreach (array_combine($images, $images2) as $file => $file2) {

                    $file_data = array(

                        'img' => $file,

                        'thumbnail' => $file2,

                        'item_id' => $insert_id

                    );

                    $this->db->insert('products_photo', $file_data);

                }

            $cover_image = $images[0];

            $cover_image_data = array(

                    'is_cover' => 1

                );

              $query=  $this->db->where('img', $cover_image)->update('products_photo', $cover_image_data);



        }else{

            $this->db->insert('products_subcategory', $data);

            $insert_id = $this->db->insert_id();

            $rs = $this->master_model->getData('products_photo',['item_id'=>$duplicate_id]);

            foreach ($rs as $file) {

                    $file_data = array(

                        'img' => $file->img,

                        'thumbnail' => $file->thumbnail,

                        'item_id' => $insert_id,

                        'is_cover'=>$file->is_cover,

                    );

                    $this->db->insert('products_photo', $file_data);

                }

            }

            // login mapping

            $data = array(

                'pro_id'     => $duplicate_id,

                'map_pro_id'     => $insert_id,

            );

            $rev_data = array(

                'pro_id'     => $insert_id,

                'map_pro_id'     => $duplicate_id,

            );

            $this->master_model->add_data('products_mapping',$data);

            $this->master_model->add_data('products_mapping',$rev_data);

            $getmapdata =  $this->db->where(['pro_id'=>$duplicate_id])->get('products_mapping')->result();

            if(!empty($getmapdata))

            {

                foreach($getmapdata as $map_data)

                {

                    $rev_map_data = array(

                        'map_pro_id'     => $map_data->map_pro_id,

                        'pro_id'     => $insert_id,

                    );

                    $map_data2 = array(

                        'pro_id'     => $map_data->map_pro_id,

                        'map_pro_id'     => $insert_id,

                    );

                    if($insert_id != $map_data->map_pro_id){

                    $this->master_model->add_data('products_mapping',$map_data2);

                    $this->master_model->add_data('products_mapping',$rev_map_data);

                    }

                    //$this->master_model->delete_data('products_mapping',$id);

                }

            }

        



        if ($insert_id) {

            return $insert_id;

        } else {

            return false;

        }

    }

    public function add_product($data)

    {

        $imageCount = count($_FILES['img']['name']);

        if (!empty($imageCount)) {

            

            for ($i = 0; $i < $imageCount; $i++) {

                

                $config['file_name'] = date('Ymd') . rand(1000, 1000000);

                $config['upload_path'] = UPLOAD_PATH.'product/';

                $config['allowed_types'] = 'jpg|jpeg|png|gif|webp|svg';

                $this->load->library('upload', $config);

                $this->upload->initialize($config);

                $_FILES['imgs']['name'] = $_FILES['img']['name'][$i];

                $_FILES['imgs']['type'] = $_FILES['img']['type'][$i];

                $_FILES['imgs']['tmp_name'] = $_FILES['img']['tmp_name'][$i];

                $_FILES['imgs']['size'] = $_FILES['img']['size'][$i];

                $_FILES['imgs']['error'] = $_FILES['img']['error'][$i];

                // $fileinfo = @getimagesize($_FILES["img"]["tmp_name"][$i]);

                // $width = $fileinfo[0];

                // $height = $fileinfo[1];

                // if ($width > "300" || $height > "200") {

                

                //         $return['res'] = 'error';

                //         $return['msg'] = 'Image dimension should be within 300X200';

                  

                // }

                if ($this->upload->do_upload('imgs')) {

                 

                    $imageData = $this->upload->data();

                     if($_FILES['imgs']['type']=='image/webp')

                        {

                                $img =  imagecreatefromwebp(UPLOAD_PATH.'product/'. $imageData['file_name']);

//                                imagepalettetotruecolor($img);

//                                imagealphablending($img, true);

//                                imagesavealpha($img, true);

                                imagewebp($img, UPLOAD_PATH.'product/thumbnail/'. $imageData['file_name'],80);

                                imagedestroy($img);

                        }

                        else

                        {

                            $config2 = array(

                                'image_library' => 'gd2', //get original image

                                'source_image' =>   UPLOAD_PATH.'product/'. $imageData['file_name'],

                                'width' => 640,

                                'height' => 360,

                                'new_image' =>  UPLOAD_PATH.'product/thumbnail/'. $imageData['file_name'],

                            );

                            $this->load->library('image_lib');

                            $this->image_lib->initialize($config2);

                            $this->image_lib->resize();

                            $this->image_lib->clear();

                        }



                    $images[] = "product/" . $imageData['file_name'];

                    $images2[] = "product/thumbnail/" . $imageData['file_name'];

                }

            }

        }



        //application upload code

        // $config['file_name'] = rand(10000, 10000000000);    

        // $config['upload_path'] = UPLOAD_PATH.'product/';

        // $config['allowed_types'] = 'jpg|jpeg|png|gif|webp';

        // $this->load->library('upload', $config);

        // $this->upload->initialize($config);



        // if (!empty($_FILES['application']['name'])) {



        //     //upload images

        //     $_FILES['applications']['name'] = $_FILES['application']['name'];

        //     $_FILES['applications']['type'] = $_FILES['application']['type'];

        //     $_FILES['applications']['tmp_name'] = $_FILES['application']['tmp_name'];

        //     $_FILES['applications']['size'] = $_FILES['application']['size'];

        //     $_FILES['applications']['error'] = $_FILES['application']['error'];



        //     if ($this->upload->do_upload('applications')) {

        //         $image_data = $this->upload->data();

             

        //         $fileName = "product/" . $image_data['file_name'];

        //     }

        //     $data['application'] = $fileName;

        // } else {

        //     $data['application'] = "";

        // }

        // end application upload code

       



        if (!empty($images))

        {     

            $this->db->insert('products_subcategory', $data);

            $insert_id = $this->db->insert_id();

            foreach (array_combine($images, $images2) as $file => $file2) {

                    $file_data = array(

                        'img' => $file,

                        'thumbnail' => $file2,

                        'item_id' => $insert_id

                    );

                    $this->db->insert('products_photo', $file_data);

                }

            $cover_image = $images[0];

            $cover_image_data = array(

                    'is_cover' => 1

                );

              $query=  $this->db->where('img', $cover_image)->update('products_photo', $cover_image_data);



              //sitemap code

              //need to implement  sitemap function through helper class

            

//                $product_data          = $this->master_model->product($insert_id);

//                $url = base_url('product-detail/').$insert_id."/".$product_data->parent_cat_id."/".$product_data->is_parent;

//                $users = simplexml_load_file(SITEMAP_URL);

//                $user = $users->addChild('url');

//                $user->addChild('id', $insert_id);

//                $user->addChild('loc', $url);

//                $user->addChild('lastmod', date('Y-m-d'));

//                $user->addChild('priority', '1.0');

//                $dom = new DomDocument();

//                $dom->preserveWhiteSpace = false;

//                $dom->formatOutput = true;

//                $dom->loadXML($users->asXML());

//                $dom->save(SITEMAP_URL);

//                //end sitemap code

        }



        if ($insert_id) {

            return $insert_id;

        } else {

            return false;

        }

    }

    // by Ajay

    public function add_class_pro_map($data_class){

        $this->db->insert('class_pro_maps', $data_class);

    }

    ///by zahid

    public function add_cat_pro_map($data_cat_id){

        $this->db->insert('cat_pro_maps', $data_cat_id);

    }





    ///by zahid

    public function get_cat_pro_map_for_product_list(){

        $this->db

        ->select('t1.*, t2.*')

        ->from('cat_pro_maps t1')

        ->join('products_category t2', 't2.id = t1.cat_id')

        ->where(['t2.is_deleted'=>'NOT_DELETED','t2.active'=>'1']);

        return $this->db->get()->result();

    }

    //  By Ajay Kumar

    public function get_class_pro_map_for_product_list(){

        $this->db

        ->select('t1.*, t2.*')

        ->from('class_pro_maps t1')

        ->join('class_master t2', 't2.id = t1.class')

        ->where(['t2.is_deleted'=>'NOT_DELETED','t2.active'=>'1']);

        return $this->db->get()->result();

    }



    public function products($groups,$class_id,$parent_id,$pro_id,$cat_id,$child_cat_id,$type,$search,$limit=null,$start=null)

    {

        if ($limit!=null) {

            $this->db->limit($limit, $start);

        }

        $this->db

        ->select('t1.*,t2.img,t2.thumbnail,t2.is_cover,t2.id as cover_id,t4.qty as qty,t4.mrp as mrp,t4.selling_rate as selling_rate,t4.purchase_rate as purchase_rate, t4.id as inventory_id')

        ->from('products_subcategory t1')

        ->join('products_photo t2', 't2.item_id = t1.id AND t2.is_cover = "1"','LEFT')

        ->join('shops_inventory t4', 't4.product_id = t1.id AND t4.status = "1" AND t4.is_deleted = "NOT_DELETED"', 'LEFT')

        //->join('cat_pro_maps t5', 't5.pro_id = t1.id', 'LEFT')

        //->join('group_master t6','t6.id=t1.group_id','left')

        ->where(['t1.is_deleted' => 'NOT_DELETED'])

        ->order_by('t1.added','desc');

        if ($search != 'null'  && $cat_id =='null' || $search != 'null') {

            $this->db->group_start();

            $this->db->like('t1.name', $search);

            $this->db->or_like('t1.search_keywords', $search);

            $this->db->or_like('t1.product_code', $search);

            $this->db->group_end();

        }

         if ($type!='null') {

            $this->db->where('t1.flag',$type);

              }

        if (!empty($pro_id)) {

            $this->db->where_in('t1.id',$pro_id);

            $this->db->where('t1.is_deleted','NOT_DELETED');

            // $this->db->where('t2.is_cover','1');    

        }

        if($limit!=null)

            return $this->db->get()->result();

        else

            return $this->db->get()->num_rows();

    }





    public function product($id)

    {

        $query = $this->db

        ->select('t1.*,t1.parent_cat_id,t2.id as cat_id,t2.name as cat_name,t2.is_parent,t3.id as main_cat_id,t3.name as main_cat_name,t3.is_parent as main_is_parent')

        ->from('products_subcategory t1')

        ->join('products_category t2', 't2.id = t1.parent_cat_id','left')        

        ->join('products_category t3', 't3.id = t1.sub_cat_id','left')        

        ->where(['t1.is_deleted' => 'NOT_DELETED','t1.id'=>$id])

        ->get();

        return $query->row();

        // return $this->db->get_where('products_subcategory',['id'=>$id])->row();

    }



    public function product_img($id)

    {

        return $this->db->get_where('products_photo',['item_id'=>$id])->result();

    }

    public function getcatid($id)

    {

        return $this->db->get_where('cat_pro_maps',['pro_id'=>$id])->row();

    }





    ///by zahid

    public function get_cat_pro_map($id)

    {

        $query = $this->db

        ->select('t1.*,t2.*')

        ->from('cat_pro_maps t1')

        ->join('products_category t2', 't2.id = t1.cat_id','left')

        ->where(['t1.pro_id'=>$id])

        ->get();

        return $query->result();

    }

    public function get_class_pro_map($id)

    {

        $query = $this->db

        ->select('t1.*,t2.*')

        ->from('class_pro_maps t1')

        ->join('class_master t2', 't2.id = t1.class','left')

        ->where(['t1.pro_id'=>$id])

        ->get();

        return $query->result();

    }

    

    public function product_img_upload($id)

    {

        $imageCount = count($_FILES['img']['name']);

        if (!empty($imageCount)) {

            for ($i = 0; $i < $imageCount; $i++) {

                $config['file_name'] = date('Ymd') . rand(1000, 1000000);

                $config['upload_path'] = UPLOAD_PATH.'product/';

                $config['allowed_types'] = 'jpg|jpeg|png|gif|pdf|xlsx|xls|csv';

                $this->load->library('upload', $config);

                $this->upload->initialize($config);

                $_FILES['imgs']['name'] = $_FILES['img']['name'][$i];

                $_FILES['imgs']['type'] = $_FILES['img']['type'][$i];

                $_FILES['imgs']['tmp_name'] = $_FILES['img']['tmp_name'][$i];

                $_FILES['imgs']['size'] = $_FILES['img']['size'][$i];

                $_FILES['imgs']['error'] = $_FILES['img']['error'][$i];



                if ($this->upload->do_upload('imgs')) {

                    $imageData = $this->upload->data();

                    $images[] = "product/" . $imageData['file_name'];

                }

            }

        }



        if ($images != '') {            

            foreach ($images as $file) {

                $file_data = array(

                    'img' => $file,

                    'item_id' => $id

                );

                $this->db->insert('products_photo', $file_data);

            }

            $cover_image = $images[0];

            $cover_image_data = array(

                    'is_cover' => 1

                );

              $query=  $this->db->where('img', $cover_image)->update('products_photo', $cover_image_data);

        }







    }

    



    public function fetch_shop($bid)

    {

        $data = $this->db->get_where('shops',['business_id' => $bid , 'is_deleted' => 'NOT_DELETED'])->result();

        echo "<option value=''>Select Shop</option>";

        foreach($data as $val)

        {

            echo "<option value='" . $val->id . "'>" . $val->shop_name . "</option>";

        }

    }

    public function view_pincodes_criteria()

    {

        $query = $this->db

        ->select('t1.*,t2.shop_name,t2.business_id')

        ->from('pincodes_criteria t1')

        ->join('shops t2', 't2.id = t1.shop_id')        

        ->where(['t1.is_deleted' => 'NOT_DELETED'])

        ->get();

        return $query->result();

    }

    public function fetch_search_pincode($search)

    {

        $query = $this->db

        ->select('t1.*,t2.shop_name,t2.business_id')

        ->from('pincodes_criteria t1')

        ->join('shops t2', 't2.id = t1.shop_id')        

        ->where(['t1.is_deleted' => 'NOT_DELETED','t1.pincode'=>$search])

        ->get();

        return $query->result();

    }

    public function fetch_slot($day,$shop_id)

    {

        return $this->db->get_where('booking_slots',['day' => $day,'shop_id' => $shop_id])->result();

       

    }

    public function get_booking_slots()

    {

        $query = $this->db

        ->select('t1.*,t2.shop_name,t2.business_id')

        ->from('booking_slots t1')

        ->join('shops t2', 't2.id = t1.shop_id')        

        ->where(['t1.is_deleted' => 'NOT_DELETED'])

        ->order_by('day','desc')

        ->get();

        return $query->result();

    }

    

    public function delete_booking_slot($id)

    {

        return $this->db->where('id', $id)->delete('booking_slots');

    }



    public function fetch_city($sid)

    {

        $data = $this->db->get_where('cities',['state_id' => $sid , 'is_deleted' => 'NOT_DELETED'])->result();

        echo "<option value=''>Select City</option>";

        foreach($data as $val)

        {

            echo "<option value='" . $val->id . "'>" . $val->name . "</option>";

        }

    }

    //fetch business by city id

    public function fetch_business($cid)

    {

        $data = $this->db->get_where('business',['city' => $cid , 'is_deleted' => 'NOT_DELETED'])->result();

        echo "<option value=''>Select Business</option>";

        foreach($data as $val)

        {

            echo "<option value='" . $val->id . "'>" . $val->title . "</option>";

        }

    }

        //edit society 

    public function edit_society($id, $data)

    {

        return $this->db->where('socity_id ', $id)->update('society_master', $data);

    }

        //deleted society

    public function delete_society($id)

    {

        $is_deleted = array('is_deleted' => 'DELETED');

        return $this->db->where('socity_id', $id)->update('society_master', $is_deleted);

    }

        //deleted data

    public function delete_pincodes_criteria($id)

    {

        return $this->db->where('id', $id)->update('pincodes_criteria',['is_deleted'=>'DELETED']);

    }

    public function get_categories($parent_id,$cat_id)

    {

        $this->db->order_by('seq','asc')->where(['is_deleted' => 'NOT_DELETED']);

        if ($cat_id!=='null') {

            $this->db->group_start();

            $this->db->like('id', $cat_id);

            $this->db->or_like('is_parent', $cat_id);

            $this->db->where('is_deleted','NOT_DELETED');

            $this->db->group_end();

            

        }

        return $this->db->get('products_category')->result();

    }

    public function get_categories_map($cat_id)

    {

        $this->db->order_by('seq','asc')->where(['is_deleted' => 'NOT_DELETED']);

        if ($cat_id!='') {

            $this->db->group_start();

            $this->db->like('id', $cat_id);

            $this->db->or_like('is_parent', $cat_id);

            $this->db->where('is_deleted','NOT_DELETED');

            $this->db->group_end();

            

        }

        return $this->db->get('products_category')->result();

    }

    public function get_cat()

    {

        $this->db->order_by('seq','asc')->where(['is_deleted' => 'NOT_DELETED']);



        return $this->db->get('products_category')->result();

    }

        //get parent categories

    // public function get_parent_cat($limit=null,$start=null)

    // {

    //     if ($limit!=null) {

    //         $this->db->limit($limit, $start);

    //     }

    //  $this->db->order_by('seq','asc')->where(['is_deleted' => 'NOT_DELETED', 'is_parent' => '0']);

    //  return $this->db->get('products_category')->result();

    // }

    public function category($id)

    {

        $query = $this->db

        ->select('t1.*,t2.id as subcat_id,t2.name as subcat_name,t2.is_parent as subcat_is_parent')

        ->from('products_category t1')

        ->join('products_category t2', 't1.is_parent = t2.id AND t2.is_parent!=0','left')        

        ->where(['t1.is_deleted' => 'NOT_DELETED','t1.id'=>$id])

        ->get();

        return $query->row();

        // return $this->db->get_where('products_category',['id'=>$id])->row();

    }

    //edit data 

    public function change_society_status($socity_id,$data1)

    {

        return $this->db->where('socity_id', $socity_id)->update('society_master', $data1);

    }

        //view unit master

    public function view_unit_master()

    {

        $query = $this->db->order_by('name','asc')->get_where('unit_master', ['is_deleted' => 'NOT_DELETED']);

        return $query->result();

    }

    //view brand master

    public function view_brand_master()

    {

        $query = $this->db->order_by('name','asc')->get_where('brand_master', ['is_deleted' => 'NOT_DELETED']);

        return $query->result();

    }

    //view flavour master

    public function view_flavour_master()

    {

        $query = $this->db->order_by('name','asc')->get_where('flavour_master', ['is_deleted' => 'NOT_DELETED']);

        return $query->result();

    }

    public function fetch_category($pid)

    {

        $data = $this->db->get_where('products_category',['is_parent' => $pid , 'is_deleted' => 'NOT_DELETED'])->result();

        echo "<option value=''>Select Category</option>";

        foreach($data as $val)

        {

            echo "<option value='" . $val->id . "'>" . $val->name . "</option>";

        }

    }

    public function fetch_sub_category($pid)

    {

        $data = $this->db->get_where('products_category',['is_parent' => $pid , 'is_deleted' => 'NOT_DELETED'])->result();

        echo "<option value=''>Select Sub Category</option>";

        foreach($data as $val)

        {

            echo "<option value='" . $val->id . "'>" . $val->name . "</option>";

        }

    }

    

        //get data by id

    public function get_parent_id()

    {

        $query = $this->db->get_where('products_category');

        return $query->row();

    }

        //deleted pro image

    public function delete_pro_image($id){

        $data1['prod_images'] = $this->master_model->get_row_data1('products_photo','id',$id);

        $prod_image = ltrim($data1['prod_images']->img, '/');

        $prod_thumb = ltrim($data1['prod_images']->thumbnail, '/');

        if(is_file(DELETE_PATH.$prod_image))

        {

            unlink(DELETE_PATH.$prod_image);

        }

        if(is_file(DELETE_PATH.$prod_thumb))

        {

            unlink(DELETE_PATH.$prod_thumb);

        }

        return $this->db->where('id', $id)->delete('products_photo');

    }

    public function remove_product_cover($p1){

        $change_cover = array('is_cover' => '0');

        return $this->db->where('item_id', $p1)->update('products_photo', $change_cover);

    }

    public function make_product_cover($id){

        $is_cover = array('is_cover' => '1');

        return $this->db->where('id', $id)->update('products_photo', $is_cover);

    }

    public function update_prod_seq($id,$data){

        return $this->db->where('id', $id)->update('products_photo',$data);

    }

    public function add_product_props($data)

    {

        return $this->db->insert('product_props', $data);

    }

    public function update_product_props($product_id,$props_id,$data)

    {

        return $this->db->where(['product_id' => $product_id,'props_id' => $props_id])->update('product_props', $data);

    }

    public function update_default_product_props($id,$data){

        return $this->db->where(['id'=>$id])->update('product_props', $data);

    }

    public function delete_prop_val($id){

        return $this->db->where('id', $id)->delete('product_props');

    }

    public function get_product_props($product_id,$props_id)

    {

        $query = $this->db->get_where('product_props', ['product_id' => $product_id,'props_id' => $props_id]);

        return ($query->num_rows()>0)?true:false;

    }

    public function get_default_product_props($product_id,$props_id){

        return $this->db->get_where('product_props', ['product_id' => $product_id,'props_id'=>$props_id, 'is_default'=>1])->result();        

    }    

    public function check_cancellation_existence($product_id,$shop_id)

    {

        $query = $this->db->get_where('products_cancellation_policy', ['pro_id' => $product_id,'shop_id' => $shop_id]);

        return ($query->num_rows()>0)?true:false;

    }



    //get data by id

    public function get_property_val($id)

    {

        //correction done by techfi is_selectable condition was there 

        $query = $this->db

        ->select('t1.*,t2.name,t2.id as propid,t2.is_selectable')

        ->from('product_props t1')

        ->join('product_props_master t2', 't2.id = t1.props_id')        

        ->where(['t1.product_id' => $id])

        ->get();

        return $query->result();

    }

    

    public function get_property_val_new($id)

    {

        //correction by techfi seq is implemented without alias

        $query = $this->db

        ->select('t1.*,t2.name,t2.id as propid,t2.is_selectable,t3.value')

        ->from('product_props t1')

        ->join('product_props_master t2', 't2.id = t1.props_id','left') 

        ->join('product_props_value t3','t3.id=t1.value_id','left')       

        ->where(['t1.product_id' => $id,'is_selectable'=>'3'])

        ->order_by('t3.seq','asc')

        ->get();

        return $query->result();

    }



    public function get_property_val_by_id($id)

    {

        $query = $this->db

        ->select('*')

        ->from('product_props')

        ->where(['id' => $id])

        ->get();

        return $query->result();

    }



        //Home Banner

        public function add_home_banner($data)

        {

            $config['file_name'] = rand(10000, 10000000000);

            $config['upload_path'] = UPLOAD_PATH.'banners/';

            $config['allowed_types'] = 'jpg|jpeg|png|gif|pdf|webp|svg';

            $this->load->library('upload', $config);

            $this->upload->initialize($config);

    

            if (!empty($_FILES['img']['name'])) {

                //upload images

                $_FILES['imgs']['name'] = $_FILES['img']['name'];

                $_FILES['imgs']['type'] = $_FILES['img']['type'];

                $_FILES['imgs']['tmp_name'] = $_FILES['img']['tmp_name'];

                $_FILES['imgs']['size'] = $_FILES['img']['size'];

                $_FILES['imgs']['error'] = $_FILES['img']['error'];

    

                if ($this->upload->do_upload('imgs')) {

                    $image_data = $this->upload->data();

                    $fileName = "banners/" . $image_data['file_name'];

                }

                $data['img'] = $fileName;

            } else {

                $data['img'] = "";

            }

            return $this->db->insert('home_banners', $data);

        }

        public function view_home_banner($type)

        {

            if($type !=''){

            $query = $this->db

            ->select('t1.*,t2.id as shop_id,t2.shop_name,t2.business_id')

            ->from('home_banners t1')

            ->join('shops t2', 't2.id = t1.shop_id')        

            ->where(['t1.is_deleted' => 'NOT_DELETED','t1.banner_type'=>$type])

            ->order_by('t1.seq','asc')

            ->get();

            return $query->result();

            }else

            {

                $query = $this->db

                ->select('t1.*,t2.id as shop_id,t2.shop_name,t2.business_id')

                ->from('home_banners t1')

                ->join('shops t2', 't2.id = t1.shop_id')        

                ->where(['t1.is_deleted' => 'NOT_DELETED'])

                ->order_by('t1.seq','asc')

                ->get();

                return $query->result();

            }

        }

        public function get_home_banner($type,$shop_id)

        {

            $query = $this->db

            ->select('t1.*,t2.id as shop_id,t2.shop_name,t2.business_id')

            ->from('home_banners t1')

            ->join('shops t2', 't2.id = t1.shop_id')        

            ->where(['t1.is_deleted' => 'NOT_DELETED','t1.shop_id' => $shop_id,'t1.banner_type'=>$type])

            ->order_by('t1.seq','asc')

            ->get();

            return $query->result();

        }

        public function edit_home_banner($data,$id)

        {

            $config['file_name'] = rand(10000, 10000000000);

            $config['upload_path'] = UPLOAD_PATH.'banners/';

            $config['allowed_types'] = 'jpg|jpeg|png|gif|pdf|webp|svg';

            $this->load->library('upload', $config);

            $this->upload->initialize($config);

            

            if (!empty($_FILES['img']['name'])) {

                //upload images

                $_FILES['imgs']['name'] = $_FILES['img']['name'];

                $_FILES['imgs']['type'] = $_FILES['img']['type'];

                $_FILES['imgs']['tmp_name'] = $_FILES['img']['tmp_name'];

                $_FILES['imgs']['size'] = $_FILES['img']['size'];

                $_FILES['imgs']['error'] = $_FILES['img']['error'];

    

                if ($this->upload->do_upload('imgs')) {

                    $image_data = $this->upload->data();

                    $fileName = "banners/" . $image_data['file_name'];

                }

    

                if (!empty($fileName)) 

                {

                    $data2 = $this->db->get_where('home_banners', ['id' =>$id])->row();

                    if (!empty($data2->img))

                    {

                        if(is_file(DELETE_PATH.$data2->img))

                        {

                            unlink(DELETE_PATH.$data2->img);

                        }

                    }

                    $data['img'] = $fileName;

                } 

                

            }

            

            return $this->db->where('id', $id)->update('home_banners', $data); 

        }

        public function view_home_header()

        {

            $query = $this->db

            ->select('t1.*,t2.id as shop_id,t2.shop_name,t2.business_id')

            ->from('home_headers t1')

            ->join('shops t2', 't2.id = t1.shop_id')        

            ->where(['t1.is_deleted' => 'NOT_DELETED'])

            ->order_by('t1.seq','asc')

            ->get();

            return $query->result();

        }

        public function get_home_header($shop_id)       //function using in master_shop controller

        {

            $query = $this->db

            ->select('t1.*,t2.id as shop_id,t2.shop_name,t2.business_id')

            ->from('home_headers t1')

            ->join('shops t2', 't2.id = t1.shop_id')        

            ->where(['t1.is_deleted' => 'NOT_DELETED','t1.shop_id' => $shop_id])

            ->order_by('t1.seq','asc')

            ->get();

            return $query->result();

        }

        public function get_headers_mapping($id)

        {

            $query = $this->db

            ->select('t1.*,t2.id as prod_id,t2.product_code,t2.name as prod_name,t3.title,t4.img,t4.thumbnail')

            ->from('home_headers_mapping t1')

            ->join('products_subcategory t2', 't2.id = t1.value','left')        

            ->join('home_headers t3', 't3.id = t1.header_id','left')        

            ->join('products_photo t4', 't4.item_id = t2.id AND t4.is_cover="1"','left')       

            ->where(['t1.header_id' => $id])

            ->get();

            return $query->result();

        }

        public function fetch_products($id)

        {

            $query = $this->db

            ->select('t1.*,t1.id as prod_id,t2.img,t2.thumbnail,t4.name as flavour')

            ->from('products_subcategory t1')

            ->join('products_photo t2', 't2.item_id = t1.id AND t2.is_cover="1" ','left')           

            ->join('cat_pro_maps t3', 't3.pro_id = t1.id','left')    

            ->join('flavour_master t4', 't1.flavour_id = t4.id','left')        

            ->where(['t3.cat_id' => $id,'t1.is_deleted' =>'NOT_DELETED'])

            ->get();

            return $query->result();

        }

        public function fetch_products_id($id)

        {

            

            $query = $this->db

            ->select('t1.*,t1.id as prod_id,t2.img,t2.thumbnail,t4.name as flavour,t3.cat_id,map.map_pro_id')

            ->from('products_mapping map')

            ->join('products_subcategory t1', 't1.id = map.map_pro_id','left')

            ->join('products_photo t2', 't2.item_id = t1.id','left')           

            ->join('cat_pro_maps t3', 't3.pro_id = t1.id','left')    

            ->join('flavour_master t4', 't1.flavour_id = t4.id','left')        

            ->where(['map.pro_id' => $id,'t2.is_cover' =>'1','t1.is_deleted' =>'NOT_DELETED'])

            ->group_by('map.map_pro_id')

            ->get();

            return $query->result();

        }

        public function fetch_products_search($search)

        {

            $query1 = $this->db

            ->select('t1.*')

            ->from('products_subcategory t1')      

            ->where(['t1.is_deleted' =>'NOT_DELETED']);

            if ($search != 'null') {

                $this->db->group_start();

                $this->db->like('t1.name', $search);

                $this->db->or_like('t1.search_keywords', $search);

                $this->db->or_like('t1.product_code', $search);

                $this->db->group_end();

            }

            $rs =  $query1->get()->row();

            $query = $this->db

            ->select('t1.*,t1.id as prod_id,t2.img,t2.thumbnail,t4.name as flavour,t3.cat_id')

            ->from('products_subcategory t1')

            ->join('products_photo t2', 't2.item_id = t1.id','left')           

            ->join('cat_pro_maps t3', 't3.pro_id = t1.id','left')    

            ->join('flavour_master t4', 't1.flavour_id = t4.id','left')        

            ->where(['t1.id' => @$rs->id,'t2.is_cover' =>'1','t1.is_deleted' =>'NOT_DELETED'])

            ->group_by('t1.id')

            ->get();

            return $query->result();

          

        }

        public function fetch_products_prod_id($id)

        {

            $query = $this->db

            ->select('t1.*,t1.id as prod_id,t2.img,t2.thumbnail,t4.name as flavour,t3.cat_id')

            ->from('products_subcategory t1')

            ->join('products_photo t2', 't2.item_id = t1.id','left')           

            ->join('cat_pro_maps t3', 't3.pro_id = t1.id','left')    

            ->join('flavour_master t4', 't1.flavour_id = t4.id','left')        

            ->where(['t1.id' =>$id,'t2.is_cover' =>'1','t1.is_deleted' =>'NOT_DELETED'])

            ->group_by('t1.id')

            ->get();

            return $query->result();

          

        }

        public function getCatIDs($id)

        {

            $query = $this->db

            ->select('t2.*,t1.pro_id')

            ->from('cat_pro_maps t1')

            ->join('products_category t2', 't1.cat_id = t2.id','left')         

            ->where(['t1.pro_id' =>$id,'t2.is_deleted' =>'NOT_DELETED','t2.level'=>'3'])

            ->get();

            return $query->result();

          

        }

        

        

        public function fetch_products2($id,$psearch)

        {

            $query = $this->db

            ->select('t1.*,t1.id as prod_id,t2.img')

            ->from('products_subcategory t1')

            ->join('products_photo t2', 't2.item_id = t1.id')                 

            ->where(['t2.is_cover' =>'1','t1.is_deleted' =>'NOT_DELETED']);

            if ($psearch !='null' && $id =='null' || $psearch !='null') {

                $this->db->group_start();

                $this->db->like('t1.name', $psearch);

                $this->db->or_like('t1.product_code', $psearch);

                $this->db->group_end();

            }

            if ($id !='null') {

                $this->db->where('t1.parent_cat_id', $id);

            }

            return $query->get()->result();

        }

        public function delete_header_map($id)

        {

            return $this->db->where('id', $id)->delete('home_headers_mapping');

        }

        public function delete_header_mapping($pid,$headerid)

        {

            return $this->db->where(['value' => $pid,'header_id' =>$headerid])->delete('home_headers_mapping');

        }



        //Category Header Mapping

        public function get_category_mapping($id)

        {

            $query = $this->db

            ->select('t1.*,t2.name,t2.icon,t2.id as catid,t3.title')

            ->from('home_headers_mapping t1')

            ->join('products_category t2', 't2.id = t1.value') 

            ->join('home_headers t3', 't3.id = t1.header_id')        

            ->where(['t1.header_id' => $id])

            ->get();

            return $query->result();

        }

        public function delete_category_map($id)

        {

            return $this->db->where('id', $id)->delete('home_headers_mapping');

        }

        public function delete_category_mapping($cid,$headerid)

        {

            return $this->db->where(['value' => $cid,'header_id' =>$headerid])->delete('home_headers_mapping');

        }



        public function delete_product($id)

        {

          

            // $data1['images']        = $this->master_model->product_img($id);

            // unlink($data1['images']->img);

            $is_deleted = array('is_deleted' => 'DELETED');

            return $this->db->where('id', $id)->update('products_subcategory', $is_deleted);

        }

        public function get_cancellation_data($pid)

        {

            $query = $this->db

            ->select('t1.*,t2.shop_name,t2.id as shop_id,t2.business_id')

            ->from('products_cancellation_policy t1')

            ->join('shops t2', 't2.id = t1.shop_id')  

            ->where('pro_id',$pid)

            ->get();

            return $query->result();

        }



        public function edit_product($data,$id)

        {

            $config['file_name'] = rand(10000, 10000000000);

            $config['upload_path'] = UPLOAD_PATH.'product/';

            $config['allowed_types'] = 'jpg|jpeg|png|gif|webp|svg';

            $this->load->library('upload', $config);

            $this->upload->initialize($config);

    

            if (!empty($_FILES['application']['name'])) {

                //upload images

                $_FILES['applications']['name'] = $_FILES['application']['name'];

                $_FILES['applications']['type'] = $_FILES['application']['type'];

                $_FILES['applications']['tmp_name'] = $_FILES['application']['tmp_name'];

                $_FILES['applications']['size'] = $_FILES['application']['size'];

                $_FILES['applications']['error'] = $_FILES['application']['error'];

    

                if ($this->upload->do_upload('applications')) {

                    $image_data = $this->upload->data();

                   

                    $fileName = "product/" . $image_data['file_name'];

                }

    

                $data['application'] = $fileName;

                $data1['app_image'] = $this->master_model->get_row_data1('products_subcategory','id',$id);

                $application = ltrim($data1['app_image']->application, '/');

                if(is_file(DELETE_PATH.$application))

                {

                    unlink(DELETE_PATH.$application);

                }

            }

      



            //update xml

            // $cat_data          = $this->master_model->get_row_data('products_category','id',$data['parent_cat_id']);

            // $users = simplexml_load_file(SITEMAP_URL);

            // $flag = "0";

            // $url = base_url('product-detail/').$id."/".$data['parent_cat_id']."/".$cat_data->is_parent;

            // foreach($users->url as $user){

            //     if($user->id == $id){

            //         if($user->id == $id)

            //         {

            //             $flag = '1';

            //         }

            //         $user->loc = $url;

            //         $user->lastmod = date('Y-m-d');

            //         $user->priority = '1.0';

            //         break;

            //     }

            // }

            // if($flag == '1') 

            // {

            //     file_put_contents(SITEMAP_URL, $users->asXML());

            // }

            // else

            // {

            //     $user = $users->addChild('url');

            //     $user->addChild('id', $id);

            //     $user->addChild('loc', $url);

            //     $user->addChild('lastmod', date('Y-m-d'));

            //     $user->addChild('priority', '1.0');

            //     $dom = new DomDocument();

            //     $dom->preserveWhiteSpace = false;

            //     $dom->formatOutput = true;

            //     $dom->loadXML($users->asXML());

            //     $dom->save(SITEMAP_URL);

            // }



            return $this->db->where('id', $id)->update('products_subcategory', $data); 

        }



        public function get_parent_cat($parent_id,$cat_id,$limit=null,$start=null)

        {

            if ($limit!=null) {

                $this->db->limit($limit, $start);

            }

            $this->db->where(['is_deleted' => 'NOT_DELETED', 'is_parent' => '0']);

            if ($parent_id!='null') {

                $this->db->like('id', $parent_id);

                $this->db->where('is_deleted','NOT_DELETED');

            }

            return $this->db->get('products_category')->result();

        }

        public function getCat($parent_id,$cat_id)

        {

            

            $this->db->where(['is_deleted' => 'NOT_DELETED', 'is_parent' => '0']);

            if ($parent_id!='null') {

                $this->db->like('id', $parent_id);

                $this->db->where('is_deleted','NOT_DELETED');

            }

            return $this->db->get('products_category')->result();

        }

        

        public function get_parent_cat_list()

        {

            $this->db->where(['is_deleted' => 'NOT_DELETED', 'is_parent' => '0']);



            return $this->db->get('products_category')->result();

        }

        public function get_flags_data1($pid)

        {

            $query = $this->db

            ->select('t1.*,t2.shop_name,t2.id as shop_id,t2.business_id')

            ->from('product_flags t1')

            ->join('shops t2', 't2.id = t1.shop_id')  

            ->where(['product_id' => $pid])

            ->get();

            return $query->row();

        }

        public function get_flags_data($pid,$shop_id)

        {

            $query = $this->db

            ->select('t1.*,t2.shop_name,t2.id as shop_id,t2.business_id')

            ->from('product_flags t1')

            ->join('shops t2', 't2.id = t1.shop_id')  

            ->where(['product_id' => $pid, 'shop_id' => $shop_id])

            ->get();

            return $query->result_array();

        }

        public function edit_product_flag($product_id,$shop_id,$data)

        {

            return $this->db->where(['product_id' => $product_id, 'shop_id' => $shop_id])->update('product_flags', $data);

        }



        //shop models

        public function get_flags($pid,$shop_id)

        {

            $query = $this->db

            ->select('t1.*,t2.shop_name,t2.id as shop_id,t2.business_id')

            ->from('product_flags t1')

            ->join('shops t2', 't2.id = t1.shop_id')  

            ->where(['product_id' => $pid, 'shop_id' => $shop_id])

            ->get();

            return $query->row();

        }

        public function get_category()

        {

            $query = $this->db

            ->select('t1.*,t1.name as cat_name,t2.name as parent_name,t2.id as parent_id')

            ->from('products_category t1')

            ->join('products_category t2', 't2.id = t1.is_parent')  

            ->where(['t1.is_deleted' => 'NOT_DELETED'])

            ->get();

            return $query->result();

        }



        public function get_map_products($pid)

        {

            $query = $this->db



            ->select('t1.id as pm_id,t2.name as product_name,t2.product_code,t2.id as pid,t3.img,t2.search_keywords')

            ->from('products_mapping t1')                                         

            ->join('products_subcategory t2', 't2.id = t1.map_pro_id','left')                          

            ->join('products_photo t3', 't3.item_id = t2.id AND t3.is_cover = 1','left')   

            ->where('t1.pro_id' , $pid)

            ->where('t2.is_deleted' , 'NOT_DELETED')

            ->get();

            return $query->result();

    

        }

        public function get_map_bundle_products($pid)

        {

            $query = $this->db



            ->select('t1.id as pm_id,t2.name as product_name,t2.product_code,t2.id as pid,t3.img,t2.search_keywords,t1.amount as price,t1.qty,t1.amount as purchase_rate')

            ->from('bundle_products_mapping t1')                                         

            ->join('products_subcategory t2', 't2.id = t1.pro_id','left')                          

            ->join('products_photo t3', 't3.item_id = t2.id AND t3.is_cover = 1','left')

            ->join('shops_inventory t4', 't4.product_id = t2.id','left')   

            ->where('t1.bundle_id' , $pid)

            ->get();

            return $query->result();

    

        }

        public function get_mapped_data($product_id)

        {

            $query = $this->db

            ->select('t1.*')

            ->from('products_mapping t1')    

            ->where('t1.map_pro_id',$product_id)   

            ->or_where('t1.pro_id',$product_id)

            ->get();

            return $query->result();

        }

        public function get_mapped_bundle_data($product_id)

        {

            $query = $this->db

            ->select('t1.*,t1.mrp as price,t4.purchase_rate')

            ->from('bundle_products_mapping t1')  

            ->join('shops_inventory t4', 't4.product_id = t1.pro_id','left')    

            ->where('t1.bundle_id',$product_id)   

            // ->or_where('t1.pro_id',$product_id)

            ->get();

            return $query->result();

        }

        /// Recommend

        public function get_recommend_products($pid)

        {

            $query = $this->db

            ->select('t1.id as rm_id,t2.name as product_name,t2.product_code,t2.id as pid,t3.img')

            ->from('recommend_p_map t1')                                         

            ->join('products_subcategory t2', 't2.id = t1.map_pro_id','left')                          

            ->join('products_photo t3', 't3.item_id = t2.id AND t3.is_cover = 1','left')   

            ->where('t1.pro_id' , $pid)

            ->get();

            return $query->result();    

        }

        public function get_recommend_data($product_id)

        {

            $query = $this->db

            ->select('t1.*')

            ->from('recommend_p_map t1')

            ->where('t1.map_pro_id',$product_id)   

            ->or_where('t1.pro_id',$product_id)

            ->get();

            return $query->result();

        }



        //Market Place Home Banner

        public function get_market_place_home_banner()

        {

            $query = $this->db

            ->select('t1.*')

            ->from('home_banners t1')     

            ->where(['t1.is_deleted' => 'NOT_DELETED','t1.shop_id' => '0'])

            ->order_by('t1.seq','asc')

            ->get();

            return $query->result();

        }

        public function add_market_place_home_banners($data)

        {

            $config['file_name'] = rand(10000, 10000000000);

            $config['upload_path'] = UPLOAD_PATH.'banners/';

            $config['allowed_types'] ='jpg|jpeg|png|gif|webp|svg';

            $this->load->library('upload', $config);

            $this->upload->initialize($config);

    

            if (!empty($_FILES['img']['name'])) {

                //upload images

                $_FILES['imgs']['name'] = $_FILES['img']['name'];

                $_FILES['imgs']['type'] = $_FILES['img']['type'];

                $_FILES['imgs']['tmp_name'] = $_FILES['img']['tmp_name'];

                $_FILES['imgs']['size'] = $_FILES['img']['size'];

                $_FILES['imgs']['error'] = $_FILES['img']['error'];

    

                if ($this->upload->do_upload('imgs')) {

                    $image_data = $this->upload->data();

                    $fileName = "banners/" . $image_data['file_name'];

                }

                $data['img'] = $fileName;

            }

            else

            {

                $data['img'] = "";

            }

            return $this->db->insert('home_banners', $data);

        }

        public function edit_market_place_home_banners($data,$id)

        {

            $config['file_name'] = rand(10000, 10000000000);

            $config['upload_path'] = UPLOAD_PATH.'banners/';

            $config['allowed_types'] = 'jpg|jpeg|png|gif|webp|svg';

            $this->load->library('upload', $config);

            $this->upload->initialize($config);

            

            if (!empty($_FILES['img']['name'])) {

                //upload images

                $_FILES['imgs']['name'] = $_FILES['img']['name'];

                $_FILES['imgs']['type'] = $_FILES['img']['type'];

                $_FILES['imgs']['tmp_name'] = $_FILES['img']['tmp_name'];

                $_FILES['imgs']['size'] = $_FILES['img']['size'];

                $_FILES['imgs']['error'] = $_FILES['img']['error'];

    

                if ($this->upload->do_upload('imgs')) {

                    $image_data = $this->upload->data();

                    $fileName = "banners/" . $image_data['file_name'];

                }

    

                if (!empty($fileName)) 

                {

                    $data2 = $this->db->get_where('home_banners', ['id' =>$id])->row();

                    if (!empty($data2->img))

                    {

                        if(is_file(DELETE_PATH.$data2->img))

                        {

                            unlink(DELETE_PATH.$data2->img);

                        }

                    }

                    $data['img'] = $fileName;

                } 

                

            }

            

            return $this->db->where('id', $id)->update('home_banners', $data); 

        }



        //remove linked shop in society master

        public function delete_linked_shop($shop_id,$society_id)

        {

            return $this->db->where(['shop_id' => $shop_id,'socity_id' =>$society_id])->delete('society_shops_link');

        }

        public function get_shops_by_society($society_id)

        {

            $query = $this->db

            ->select('t2.shop_name,t3.title,t1.is_inside')

            ->from('society_shops_link t1')    

            ->join('shops t2', 't2.id = t1.shop_id','left') 

            ->join('business t3', 't3.id = t2.business_id','left') 

            ->where(['t1.socity_id' => $society_id])

            ->get();

            return $query->result();

    

        }

        public function fetch_sub_categories($parent_id)

        {

            $data = $this->db->get_where('products_category',['is_parent' => $parent_id , 'is_deleted' => 'NOT_DELETED'])->result();

            echo "<option value=''>Select Sub Category</option>";

            foreach($data as $val)

            {

                echo "<option value='" . $val->id . "'>" . $val->name . "</option>";

            }

        }

        public function fetch_group_categories($group)

        {

            $data = $this->db->get_where('products_category',['group_id'=>$group,'is_parent' =>'0' , 'is_deleted' => 'NOT_DELETED'])->result();

            echo "<option value=''>Select  Category</option>";

            foreach($data as $val)

            {

                echo "<option value='" . $val->id . "'>" . $val->name . "</option>";

            }

        }

        public function fetch_group_class($group)

        {

            $data = $this->db->get_where('class_master',['is_deleted' => 'NOT_DELETED'])->result();

            echo "<option value=''>Select  Class</option>";

            foreach($data as $val)

            {

                echo "<option value='" . $val->id . "'>" . $val->name . "</option>";

            }

        }

        

        public function shop_social()

        {

            $query = $this->db

            ->select('t1.*,t2.shop_name,t2.business_id')

            ->from('shop_social t1')

            ->join('shops t2', 't2.id = t1.shop_id')        

            ->where(['t1.is_deleted' => 'NOT_DELETED'])

            ->get();

            return $query->result();

        }

        public function get_products($pro_id,$psearch)

        {

            $query = $this->db

            ->select('t1.*,t1.id as prod_id,t2.thumbnail')

            ->from('products_subcategory t1')

            ->join('products_photo t2', 't2.item_id = t1.id AND t2.is_cover="1"','left')    

            ->where(['t1.is_deleted' =>'NOT_DELETED']);

            if ($psearch !='null') {

                $this->db->group_start();

                $this->db->like('t1.name', $psearch);

                $this->db->or_like('t1.product_code', $psearch);

                $this->db->or_like('t1.search_keywords', $psearch);

                $this->db->group_end();

            }

            if (!empty($pro_id)) {

                $this->db->where_in('t1.id', $pro_id);

            }

            return $query->get()->result();

    

        }

 

 public function get_all_product($cat_id)

 {

     $query = $this->db

     ->select('t2.*')

     ->from('cat_pro_maps t1')

     ->join('products_subcategory t2', 't2.id = t1.pro_id')    

     ->where(['t2.is_deleted' =>'NOT_DELETED','t1.cat_id'=>$cat_id]);

     return $query->get()->result();



 }



 public function delete_multi_deal($table, $id)

    {

        $is_deleted = array('is_deleted' => 'DELETED');

        return $this->db->where('product_id', $id)->update($table, $is_deleted);

    }

    public function desabled_product_cat($table, $id)

    {

        $disabled = array('active' => '0');

        return $this->db->where('id', $id)->update($table, $disabled);

}

public function enable_product_cat($table, $id)

{

    $disabled = array('active' => '1');

    return $this->db->where('id', $id)->update($table, $disabled);

}

public function getProductDetails($shop_id, $search)
{
    $this->db->select("a.*, b.thumbnail, c.qty, c.mrp, c.purchase_rate, c.selling_rate, c.id as inventory_id, c.shop_id")
             ->from('products_subcategory a')
             ->join('products_photo b', 'b.item_id=a.id', 'left')
             ->join('shops_inventory c', 'c.product_id=a.id', 'left')
             ->where(['c.shop_id'=>$shop_id])
             ->group_start()
             ->like('a.product_code', $search)
             ->or_like('a.name', $search)
             ->or_like('a.name_portal', $search)
             ->group_end();

    return $this->db->get()->row();
}
 



public function group_master($limit=null,$start=null)

{

    if ($limit!=null) {

        $this->db->limit($limit, $start);

    }

    $this->db

    ->from('group_master a')

    ->select('a.*,b.shop_name,c.title')

    ->join('shops b', 'b.id = a.shop_id', 'left')

    ->join('business c', 'c.id = a.business_id', 'left')

    ->where(['a.is_deleted'=>'NOT_DELETED'])

    ->order_by('a.added','desc');                   

    if (@$_POST['search']) {

        $data['search'] = $_POST['search'];

        $this->db->group_start();

        $this->db->like('a.name',$_POST['search']);

        $this->db->like('b.shop_name',$_POST['search']);

        $this->db->like('c.title',$_POST['search']);

        $this->db->group_end();

    }

    if($limit!=null)

        return $this->db->get()->result();

    else

    return $this->db->get()->result();

}

public function class_master($limit=null,$start=null)

{

    if ($limit!=null) {

        $this->db->limit($limit, $start);

    }

    $this->db

    ->from('class_master a')

    ->select('a.*')

    // ->join('group_master b', 'b.id = a.group_id', 'left')

    ->where(['a.is_deleted'=>'NOT_DELETED'])

    ->order_by('a.name','asc');                 

    if (@$_POST['search']) {

        $data['search'] = $_POST['search'];

        $this->db->group_start();

        $this->db->like('a.name',$_POST['search']);

        // $this->db->like('b.name',$_POST['search']);

        $this->db->group_end();

    }

    if($limit!=null)

        return $this->db->get()->result();

    else

    return $this->db->get()->result();

}

public function school_master($limit=null,$start=null)

{

    if ($limit!=null) {

        $this->db->limit($limit, $start);

    }

    $this->db

    ->from('school_master a')

    ->select('a.*,b.name as group_name')

    ->join('group_master b', 'b.id = a.group_id', 'left')

    ->where(['a.is_deleted'=>'NOT_DELETED','b.is_deleted'=>'NOT_DELETED'])

    ->order_by('a.added','desc');                   

    if (@$_POST['search']) {

        $data['search'] = $_POST['search'];

        $this->db->group_start();

        $this->db->like('a.name',$_POST['search']);

        $this->db->like('b.name',$_POST['search']);

        $this->db->group_end();

    }

    if($limit!=null)

        return $this->db->get()->result();

    else

    return $this->db->get()->result();

}

public function subject_master($limit=null,$start=null)

{

    if ($limit!=null) {

        $this->db->limit($limit, $start);

    }

    $this->db

    ->from('subject_master a')

    ->select('a.*')

    //->join('group_master b', 'b.id = a.group_id', 'left')

    ->where(['a.is_deleted'=>'NOT_DELETED'])

    ->order_by('a.added','desc');                   

    if (@$_POST['search']) {

        $data['search'] = $_POST['search'];

        $this->db->group_start();

        $this->db->like('a.name',$_POST['search']);

       // $this->db->like('b.name',$_POST['search']);

        $this->db->group_end();

    }

    if($limit!=null)

        return $this->db->get()->result();

    else

    return $this->db->get()->result();

}



public function delivery_charges($limit=null,$start=null)

{

    if ($limit!=null) {

        $this->db->limit($limit, $start);

    }

    $this->db

    ->from('delivery_charges a')

    ->select('a.*')

    ->where(['a.is_deleted'=>'NOT_DELETED'])

    ->order_by('a.added','desc');                   

    if (@$_POST['search']) {

        $data['search'] = $_POST['search'];

        $this->db->group_start();

        $this->db->like('a.min',$_POST['search']);

       // $this->db->like('b.name',$_POST['search']);

        $this->db->group_end();

    }

    if($limit!=null)

        return $this->db->get()->result();

    else

    return $this->db->get()->result();

}

   



// by ajay kumar

public function getDistinctRowByGroupId($id) {

    $query = $this->db

    ->select('t1.*,t2.*,t3.name as group_name')

    ->from('cat_pro_maps t1')

    ->join('products_category t2', 't2.id = t1.cat_id','left')

    ->join('group_master t3', 't3.id = t2.group_id','left')

    ->where(['t1.pro_id'=>$id])

    ->order_by('t3.id','desc')

    ->group_by('t3.id')

    ->get();

    //echo $this->db->last_query();

    if ($query->num_rows() > 0) {

        return $query->result();

    } else {

        return null;

    }

}

public function checkBundleExist($productCode) {

    $this->db->where(['product_code'=>$productCode,'flag'=>'bundle','is_deleted'=>'NOT_DELETED']);

    $query = $this->db->get('products_subcategory');

    if ($query->num_rows() > 0) {

        return true;

    } else {

        return false;

    }

}

public function checkClassExist($name) {

    $this->db->where(['name'=>$name,'is_deleted'=>'NOT_DELETED']);

    $query = $this->db->get('class_master');

    if ($query->num_rows() > 0) {

        return true;

    } else {

        return false;

    }

}

public function CheckBundleInventory($bundle_id) {

    $this->db->where(['product_id'=>$bundle_id,'is_deleted'=>'NOT_DELETED']);

    $query = $this->db->get('shops_inventory');
$result = $query->row();
    if ($query->num_rows() > 0) {

        return $result->id;

    } else {

        return false;

    }

}

public function CheckProductInventory($bundle_id) {

    $this->db->where(['product_id'=>$bundle_id,'is_deleted'=>'NOT_DELETED']);

    $query = $this->db->get('shops_inventory');

    $result = $query->row();

    if ($query->num_rows() > 0) {

        return $result->id;

    } else {

        return false;

    }

}

public function checkProBundle($bundle_id,$pro_id) {

    $this->db->where(['pro_id'=>$pro_id,'bundle_id'=>$bundle_id]);

    $query = $this->db->get('bundle_products_mapping');

    if ($query->num_rows() > 0) {

        return true;

    } else {

        return false;

    }

}





public function CheckProduct($pro_code) {

    $this->db->where(['product_code'=>$pro_code,'is_deleted'=>'NOT_DELETED']);

    $query = $this->db->get('products_subcategory');

    if ($query->num_rows() > 0) {

        return true;

    } else {

        return false;

    }

}



public function CheckUnit($name) {

    $this->db->where(['name'=>$name,'is_deleted'=>'NOT_DELETED']);

    $query = $this->db->get('unit_master');

    if ($query->num_rows() > 0) {

        return true;

    } else {

        return false;

    }

}

public function CheckCategoryExist($name) {

    $this->db->where(['name'=>$name,'is_deleted'=>'NOT_DELETED']);

    $query = $this->db->get('products_category');

    $result = $query->row();

    if ($query->num_rows() > 0) {

        return $result->id;

    } else {

        return false;

    }

}

public function return_policy()

{

    $this->db

    ->from('cat_return_policy_map a')

    ->select('b.*,a.cat_id as return_cat_id,a.days')

    ->join('products_category b','b.id=a.cat_id','left')

    ->where(['b.is_deleted'=>'NOT_DELETED','b.level'=>'1'])

    ->order_by('b.id','desc');                  

    if (@$_POST['search']) {

        $data['search'] = $_POST['search'];

        $this->db->group_start();

        $this->db->like('b.name',$_POST['search']);

        $this->db->group_end();

    }

    return $this->db->get()->result();

}

public function get_categories_return_level2()

{

    $this->db

    ->from('cat_return_policy_map a')

    ->select('b.*,a.cat_id as return_cat_id,a.days')

    ->join('products_category b','b.id=a.cat_id','left')

    ->where(['b.is_deleted'=>'NOT_DELETED','b.level'=>'2'])

    ->order_by('b.id','desc');                  

    if (@$_POST['search']) {

        $data['search'] = $_POST['search'];

        $this->db->group_start();

        $this->db->like('b.name',$_POST['search']);

        $this->db->group_end();

    }

    return $this->db->get()->result();

}

public function get_categories_return_level3()

{

    $this->db

    ->from('cat_return_policy_map a')

    ->select('b.*,a.cat_id as return_cat_id,a.days')

    ->join('products_category b','b.id=a.cat_id','left')

    ->where(['b.is_deleted'=>'NOT_DELETED','b.level'=>'3'])

    ->order_by('b.id','desc');                  

    if (@$_POST['search']) {

        $data['search'] = $_POST['search'];

        $this->db->group_start();

        $this->db->like('b.name',$_POST['search']);

        $this->db->group_end();

    }

    return $this->db->get()->result();

}

public function delete_return_policy($id)

    {

        return $this->db->where('cat_id', $id)->delete('cat_return_policy_map');

    }
    public function getBundleProduct($id)

    {

        $this->db

        ->select('t2.*,t2.id as prod_id,t1.mrp,t1.amount,t1.qty')

        ->from('bundle_products_mapping t1')  

         ->join('products_subcategory t2', 't2.id=t1.pro_id ','left')

        ->where(['t2.is_deleted' => 'NOT_DELETED','t2.bundle_active_inactive'=>'1','t1.bundle_id' => $id]);

        return $this->db->get()->result();

    }


}

?>