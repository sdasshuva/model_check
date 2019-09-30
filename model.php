<?php

class model
{

    public function Fconnection()
    {
        $conn = mysql_connect("localhost", "root31", "root31@1100") or die("...Mysql connection error.");
        mysql_select_db("scmv5", $conn) or die("Unable to select database.");
    }

    private function Sconnection()
    {
        //$conn = mysqli_connect("localhost", "root2", "root2","scmv3") or die("...Mysql connection error.");
        $conn = mysqli_connect("localhost", "root31", "root31@1100", "scmv5") or die("...Mysql connection error.");
        return $conn;
    }

    private function Qconnection()
    {
        //$conn = mysqli_connect("localhost", "root2", "root2","scmv3") or die("...Mysql connection error.");
        $connq = mysqli_connect("localhost", "root31", "root31@1100", "payment") or die("...Mysql connection error.");
        return $connq;
    }


    public function login_user_pass($val)
    {
        $this->Fconnection();
        $sql_query = mysql_query("select * from admin_user_info where user_name='$val[0]'");
        $fetch_data = mysql_fetch_array($sql_query);
        return $fetch_data;
    }

    public function UserEmployeeInfo($user)
    {
        $this->Fconnection();

        $sql = mysql_query("select username,user_id,email,contact_number from tbl_user_info where username='$user'");
        $userInfoDetails = mysql_fetch_array($sql);
        return $userInfoDetails;
    }


    public function log_out($login_id)
    {
        $this->Fconnection();


//echo "UPDATE `tbl_login_log` SET `logout_time`=now(),`status`=0  WHERE `logid` = $login_id";
        $select_user_pass = mysql_query("UPDATE `login_log` SET `logout_time`=now()  WHERE `logid` = $login_id");


        return $select_user_pass;
    }


    public function log_in_nav($user, $to_date, $user_type_)
    {
        $this->Fconnection();


//echo "UPDATE `tbl_login_log` SET `logout_time`=now(),`status`=0  WHERE `logid` = $login_id";
        $log_in_nav = mysql_query("insert into login_log (LOGIN_ID,log_date,login_time,ip_address,user_type) Values ('$user','$to_date',now(),'$_SERVER[REMOTE_ADDR]','$user_type_')");

        $sql_select = mysql_query("select max(logid) from login_log");
        $sql_row = mysql_fetch_row($sql_select);


        return $sql_row;
    }


// date 21_09_2016
    public function UserAllInfo($uname)
    {
        $this->Fconnection();

        $selectUserAllInfoSql = mysql_query("
select
    tpi.employee_id,
    tpi.employee_name,
    tpi.official_cell_no,
    toi.designation,
    toi.department_name 
from
    admin_user_info as aui,
    tbl_personal_info as tpi,
    tbl_office_info as toi 
where
    aui.user_name='$uname' 
    and aui.employee_id=tpi.employee_id 
    and tpi.id=toi.emp_id
    ");
        // echo "select tpi.employee_id,tpi.employee_name,tpi.official_cell_no,toi.designation,toi.department_name from admin_user_info as aui, tbl_personal_info as tpi,tbl_office_info as toi where aui.user_name='$uname' and aui.employee_id=tpi.employee_id and tpi.id=toi.emp_id";
        $selectDataBySql = mysql_fetch_array($selectUserAllInfoSql);
        return $selectDataBySql;
    }

    // end date 21_09_2016 get_asset_code


    public function employee_user()
    {
        $this->Fconnection();
        $sql = "select * from admin_user_info";         //where user type SCM/MD/DMD/CSO/Audit/Acc
        //echo $sql;
        $select_user_pass = mysql_query("$sql");
        while ($select_user = mysql_fetch_array($select_user_sql)) {
            $employee_user[] = $select_user;
        }
        return $employee_user;
    }

    public function get_asset_code($gr_id, $item_id, $sl)
    {
        $this->Fconnection();
        $today = uniqid();
        $asset_code = 'FAH-AST-' . $today . '-GR-' . $gr_id . '-ITEM-' . $item_id . '-SL-' . $sl;
        return $asset_code;
    }

    public function login_emp_user($val, $val1)
    {
        $this->Fconnection();
        $sql = "SELECT employee_tb.emp_id,employee_tb.employee_id,employee_tb.designation,employee_tb.employee_name,employee_tb.department_name,employee_tb.active,tbl_personal_info.official_cell_no,tbl_personal_info.official_email,admin_user_info.user_name,admin_user_info.employee_id FROM tbl_office_info AS employee_tb,tbl_personal_info, admin_user_info WHERE (employee_tb.employee_id = admin_user_info.employee_id) AND (tbl_personal_info.employee_id = admin_user_info.employee_id) AND (admin_user_info.user_name='$val' or admin_user_info.employee_id='$val1')";
        //echo $sql;
        $select_user_pass = mysql_query("$sql");
        $user_fetch_data = mysql_fetch_array($select_user_pass);
        return $user_fetch_data;
    }

    ///////////////////////////
    public function loged_user_pass($val)
    {
        $this->Fconnection();
        //echo "select * from admin_user_info where user_name='$val'";
        $sql = "select * from admin_user_info where user_name='$val'";
        //echo $sql;
        $select_user_pass = mysql_query("$sql");
        $user_fetch_data = mysql_fetch_array($select_user_pass);
        return $user_fetch_data;
    }

    public function update_user_passwd($passwd, $date, $val)
    {
        $this->Fconnection();
        //echo "update admin_user_info set password='$passwd',date='$date' where user_name='$val'";
        $update_chk = mysql_query("update admin_user_info set password='$passwd',date='$date' where user_name='$val'");
        return $update_chk;
    }
    //////////////////////////////////////////////////////////////
    //////////////////////////////////////////////////////////////
    ///////////////////////User File Upload//////////////////////////
    public function user_file_upload($values)
    {
        $this->Fconnection();
        //echo $values;
        //$values=explode($values,',');
        $sql = "insert into uploded_file(file_name,user,date,pr_id) values ('$values[0]','$values[1]','$values[2]','$values[3]')";
        //echo $sql;
        $insert_into_uploded_file_sql = mysql_query("$sql");
        return $insert_into_education_sql;
    }

    public function user_file_upload_view($values)
    {
        $this->Fconnection();
        //echo $values;
        //$values=explode($values,',');
        $sql = "select * from uploded_file where pr_id='$values' order by id desc";
        //echo $sql;
        $select_into_uploded_file_sql = mysql_query("$sql");
        $select_into_uploded_file = mysql_fetch_array($select_into_uploded_file_sql);
        return $select_into_uploded_file;
    }

    /////////////////////Employee Search///////////////////////////////////
    public function AlterEmployee($empData)
    {
        $this->Fconnection();

        $selectAlterEmployeeDataSql = mysql_query("select per.employee_id,per.employee_name,off.designation,off.department_name,per.official_cell_no,per.official_email from tbl_personal_info as per,tbl_office_info as off where per.employee_name like '%$empData%' and per.employee_id=off.employee_id  limit 40");
        // $selectAlterEmployeeDataSql = mysql_query("select per.employee_id,per.employee_name,off.designation,off.department_name,per.official_cell_no,per.official_email from tbl_personal_info as per,tbl_office_info as off where per.employee_name like '%$empData%' and per.id=off.emp_id  limit 10");

        /////   Add by safa   ////////////////////////////////

        while ($allAlterEmployeeData = mysql_fetch_array($selectAlterEmployeeDataSql)) {
            $dataSet[] = $allAlterEmployeeData;
        }
        return $dataSet;
    }
    /////////////////////Employee Search///////////////////////////////////
    ///////////////////////User File Upload//////////////////////////
    //////////////////////////////////////////////////////////////
    public function tbl_tier1($val)
    {
        $this->Fconnection();
        $sql = "select * from tbl_tier where employee_id='$val'";
        //echo $sql;
        $select_user_pass = mysql_query("$sql");
        $user_fetch_data = mysql_fetch_array($select_user_pass);
        return $user_fetch_data;
    }

    public function lookup_combobox1($sql, $combo_name, $combo_id)
    {
        $this->Fconnection();
        $list = "<select name='$combo_name' id='$combo_id' class='WUIformrow_select' style='WIDTH: 110px' >";
        $list .= "<option value=''>---Choose---</option>";
        $sSqlWrk = $sql;
        //echo $sSqlWrk;
        $rswrk = mysql_query($sSqlWrk);
        if ($rswrk) {
            $rowcntwrk = 0;
            while ($datawrk = mysql_fetch_row($rswrk)) {
                $list .= "<option value=\"" . ($datawrk[0]) . "\"";
                $list .= ">" . $datawrk[1] . "</option>";
                $rowcntwrk++;
            }
        }
        mysql_free_result($rswrk);
        $list .= "</select>";
        return $list;
    }

    public function lookup_combobox2($sql, $combo_name, $combo_id)
    {
        $this->Fconnection();
        $list = "<select  name='$combo_name' id='$combo_id' style='WIDTH: 110px'> required";
        //echo $combo_name;
        $list .= "<option value=''>---Choose---</option>";
        $sSqlWrk = $sql;
        //echo $sSqlWrk;
        $rswrk = mysql_query($sSqlWrk);
        if ($rswrk) {
            $rowcntwrk = 0;
            while ($datawrk = mysql_fetch_row($rswrk)) {
                $list .= "<option value=\"" . ($datawrk[1]) . "\"";
                //$list .= ">" . $datawrk[1].' \\ '.$datawrk[2] . "</option>";
                $list .= ">" . $datawrk[2] . "</option>";
                $rowcntwrk++;
            }
        }
        mysql_free_result($rswrk);
        $list .= "</select>";
        return $list;
    }

    //////////////////////////////////////////////////////////
    public function pr_data_()
    {
        $this->Fconnection();

        $select_pr_data_sql = mysql_query("SELECT pr_tb_id,pr_id FROM `pr_info1`");
        while ($pr_res = mysql_fetch_array($select_pr_data_sql)) {
            $pr_data[] = $pr_res;
        }
        return $pr_data;
    }

    //////////////////////////////////////////////////////////
    public function add_item_info_model($values)
    {
        $this->Fconnection();
        //echo $values;
        $values = explode($values, ',');
        $sql = "insert into item_info(item_id,description,unit,price_per_unit,remarks) values ('$values[0]','$values[1]','$values[2]','$values[3]','$values[4]')";
        //echo $sql;
        $insert_into_education_sql = mysql_query("$sql");
        return $insert_into_education_sql;
    }

    public function select_user_admin($values)
    {
        $this->Fconnection();
        //echo $values;
        $values = explode($values, ',');
        $select_user_sql = mysql_query("SELECT `user_info`.user_id,`user_info`.user,`user_info`.name,`user_info`.remarks FROM `user_info`)");
        while ($select_user_info = mysql_fetch_array($select_user_sql)) {
            $user_info[] = $select_user_info;
        }
        return $user_info;
    }

    public function vendor_auto_gen_()
    {
        $this->Fconnection();
        $today = date("Y-m-d");
        $max = "select max(vendor_tb_id) from  vendor_info";
        //echo $max;
        $vendor_gen_max = mysql_query("$max");
        $vendor_max_no = mysql_fetch_row($vendor_gen_max);
        //$vendor_name=strtoupper(substr($_POST['vendor_name'],0,3));
        //echo $vendor_name;
        $a = $vendor_max_no[0] + 1;
        $increment_value_vendor = 'V' . $a;
        //echo $increment_value_vendor;
        return $increment_value_vendor;
    }

    public function add_vendor_info($values)
    {
        $this->Fconnection();
        //echo $values;
        //echo $values;
        $sql = "insert into `vendor_info`(id,name,type,address,country,zip_code,telephone,fax,cell,e_mail,contact1_name,contact1_phone,contact1_email,contact2_name,contact2_phone,contact2_email,bank_account_name,bank_account_number,bank_name,bank_address,swift_number)
                                    values ('$values[0]','$values[1]','$values[2]','$values[3]','$values[4]','$values[5]','$values[6]','$values[7]','$values[8]','$values[9]','$values[10]','$values[11]','$values[12]','$values[13]','$values[14]','$values[15]','$values[16]','$values[17]','$values[18]','$values[19]','$values[20]')";
        //  echo $sql;
        $insert_vendor_sql = mysql_query("$sql");
        return $insert_vendor_sql;
    }


    public function update_vendor_info($values)
    {
        $this->Fconnection();
        //echo $values;
        //echo $values;
        $sql = "UPDATE `vendor_info` SET `name`='$values[1]',`type`='$values[2]',`address`='$values[3]',`country`='$values[4]',`zip_code`='$values[5]',`telephone`='$values[6]',`fax`='$values[7]',`cell`='$values[8]',`e_mail`='$values[9]',`contact1_name`='$values[10]',`contact1_phone`='$values[11]',`contact1_email`='$values[12]',`contact2_name`='$values[13]',`contact2_phone`='$values[14]',`contact2_email`='$values[15]',`bank_account_name`='$values[16]',`bank_account_number`='$values[17]',`bank_name`='$values[18]',`bank_address`='$values[19]',`swift_number`='$values[20]' WHERE vendor_tb_id = $values[0]";
        // echo $sql;
        $insert_vendor_sql = mysql_query("$sql");
        return $insert_vendor_sql;
    }


    public function total_vendor_list($statement)
    {
        $this->Fconnection();

        $sql = "select vendor_tb_id,id,name,address,country,zip_code,telephone,fax,cell,e_mail,contact1_name,contact1_phone,
     contact1_email,contact2_name,contact2_phone, contact2_email,bank_account_name,bank_account_number,bank_name,bank_address,swift_number
     from `vendor_info` where vendor_tb_id<>0 $statement order by name asc";

        //echo "$sql";

        $select_all_vendor_sql = mysql_query("$sql");
        while ($vendor_list_info = mysql_fetch_array($select_all_vendor_sql)) {
            $list_vendor[] = $vendor_list_info;
        }
        return $list_vendor;
    }

    public function vendor_details_info($vendor_tb_id)
    {
        $this->Fconnection();
        $select_vendor_details_sql = mysql_query("select vendor_tb_id,id,name,address,country,zip_code,telephone,fax,cell,e_mail,contact1_name,contact1_phone,
     contact1_email,contact2_name,contact2_phone, contact2_email,bank_account_name, bank_account_number,bank_name,bank_address,swift_number from `vendor_info`
     where vendor_tb_id='$vendor_tb_id'");

        $vendor_info = mysql_fetch_array($select_vendor_details_sql);
        return $vendor_info;
    }

    public function add_item_info($values)
    {
        $this->Fconnection();
        //echo $values;
        //$values=explode($values,',');
        //$sql="insert into item_info(item_id,item_name,description,unit,remarks,status) values ('$values[0]','$values[1]','$values[2]','$values[3]','$values[4]','$values[5]')";
        $sql = "insert into all_item_info(item_tb_id,item_id,item_name,description,unit,remarks,status,group_id,group_name,user_id,item_code,flag_info,item_for_fh,status_active,huwaei_id_bom_no,sl) values ('$values[0]','$values[0]','$values[1]','$values[2]','$values[3]','$values[4]','$values[5]','$values[6]','$values[7]','$values[8]','$values[9]','$values[10]','$values[11]','$values[12]','$values[13]',$values[14])";
        //echo $sql;
        $insert_item_sql = mysql_query("$sql");
        return $insert_item_sql;
    }

    public function add_item_info_general($values)
    {
        $this->Fconnection();
        //echo $values;
        //$values=explode($values,',');
        //$sql="insert into item_info(item_id,item_name,description,unit,remarks,status) values ('$values[0]','$values[1]','$values[2]','$values[3]','$values[4]','$values[5]')";
        $sql = "insert into all_item_info(item_tb_id,item_id,item_name,description,unit,remarks,status,group_id,group_name,user_id,item_code,flag_info,item_for_fh,status_active,huwaei_id_bom_no) values ('$values[0]','$values[0]','$values[1]','$values[2]','$values[3]','$values[4]','$values[5]','$values[6]','$values[7]','$values[8]','$values[9]','$values[10]','$values[11]','$values[12]','$values[13]')";
        //echo $sql;
        $insert_item_sql = mysql_query("$sql");
        return $insert_item_sql;
    }


    public function total_item_list($statement)
    {
        $this->Fconnection();
        $sql = "SELECT `item_info`.item_tb_id,`item_info`.item_id,`item_info`.item_name,`item_info`.description,`item_info`.unit,`item_info`.price_per_unit,
     `item_info`.remarks,`item_info`.`status` FROM `item_info` where item_tb_id<>0 $statement order by `item_info`.item_name asc";
        //echo $sql;
        $select_all_item_sql = mysql_query("$sql");
        while ($item_list_info = mysql_fetch_array($select_all_item_sql)) {
            $list_item[] = $item_list_info;
        }
        return $list_item;
    }


    ///////////////////////////////////////////////////////////////
    public function item_list_all($statement)
    {
        $this->Fconnection();
        $sql1 = "SELECT `all_item_info`.item_tb_id,
  `all_item_info`.item_id,
  `all_item_info`.item_name,
  `all_item_info`.sub_group,
  `all_item_info`.sub_group_id,
  `all_item_info`.group_name,
  `all_item_info`.group_id
  FROM `all_item_info` where `all_item_info`.item_tb_id<>0 $statement order by `all_item_info`.item_name asc";
        //echo $sql1;
        $select_all_item_sql1 = mysql_query("$sql1");
        while ($item_list_info1 = mysql_fetch_array($select_all_item_sql1)) {
            $list_item1[] = $item_list_info1;
        }
        return $list_item1;
    }


    public function item_list_with_name()
    {
        $this->Fconnection();
        $sql1 = "SELECT `all_item_info`.item_tb_id,
  `all_item_info`.item_id,
  `all_item_info`.item_name,
  `all_item_info`.sub_group,
  `all_item_info`.sub_group_id,
  `all_item_info`.group_name,
  `all_item_info`.group_id
  FROM `all_item_info`";
        //echo $sql1;
        $select_all_item_sql1 = mysql_query("$sql1");

        return $select_all_item_sql1;
    }


    public function item_list_infosarkar()
    {
        $this->Fconnection();
        $sql1 = "SELECT `current_item_info_fainal_infosarkar`.item_tb_id,
  `current_item_info_fainal_infosarkar`.item_id,
  `current_item_info_fainal_infosarkar`.item_name,
  `current_item_info_fainal_infosarkar`.sub_group,
  `current_item_info_fainal_infosarkar`.sub_group_id,
  `current_item_info_fainal_infosarkar`.group_id
  FROM `current_item_info_fainal_infosarkar` WHERE current_item_info_fainal_infosarkar.flag_infosarkar_product=1";
        // echo $sql1;
        $select_all_item_sql1 = mysql_query("$sql1");

        return $select_all_item_sql1;
    }


///////
    public function item_list_all_pagination($statement, $start_from, $num_rec_per_page)
    {
        $this->Fconnection();
        $sql1 = "SELECT `all_item_info`.item_tb_id,
  `all_item_info`.item_id,
  `all_item_info`.item_name,
  `all_item_info`.sub_group,
  `all_item_info`.sub_group_id,
  `all_item_info`.group_name,
  `all_item_info`.group_id,
  `all_item_info`.unit,
   `all_item_info`.huwaei_id_bom_no
  FROM `all_item_info` where `all_item_info`.item_tb_id<>0 and `all_item_info`.item_id>0 $statement order by `all_item_info`.item_name asc  LIMIT $start_from, $num_rec_per_page";
        //echo $sql1;
        $select_all_item_sql1 = mysql_query("$sql1");

        return $select_all_item_sql1;
    }


    public function count_item_list_all($table)
    {
        $this->Fconnection();
        $sql1 = "SELECT *  FROM $table where $table.item_tb_id<>0  ";
        //  echo $sql1;
        $select_all_item_sql1 = mysql_query("$sql1");
        $total_rows = mysql_num_rows($select_all_item_sql1);
        return $total_rows;
    }






    /////////


    /*
  public function item_list_current($statement)
  {
     $this->Fconnection();
     $sql1="SELECT `all_item_info`.item_tb_id,
  `all_item_info`.item_id,
  `all_item_info`.item_name,
  `all_item_info`.sub_group,
  `all_item_info`.sub_group_id,
  `all_item_info`.group_name,
  `all_item_info`.group_id,
  current_item_info.current_quantity,
  current_item_info.unit,
  current_item_info.item_id
  FROM `all_item_info`,current_item_info where `all_item_info`.item_tb_id=current_item_info.item_id and `all_item_info`.item_name!='' $statement order by `all_item_info`.item_name asc";
   //  echo $sql1;
      $select_all_item_sql1=mysql_query("$sql1");
     while($item_list_info1=mysql_fetch_array($select_all_item_sql1))
     {
       $list_item1[]=$item_list_info1;
     }
    return $list_item1;
  }
  */
    public function item_list_current($statement)
    {
        $this->Fconnection();
        $sql1 = "SELECT `all_item_info`.item_tb_id, `all_item_info`.item_id, `all_item_info`.item_name, `all_item_info`.sub_group,
`all_item_info`.sub_group_id, `all_item_info`.group_name, `all_item_info`.group_id, current_item_info_fainal.qty,
current_item_info_fainal.unit, current_item_info_fainal.item_id
FROM `all_item_info`,current_item_info_fainal
WHERE `all_item_info`.item_tb_id=current_item_info_fainal.item_tb_id AND current_item_info_fainal.id>5169 AND `all_item_info`.item_name!=''
ORDER BY `all_item_info`.item_name ASC";
//echo $sql1;
        $select_all_item_sql1 = mysql_query($sql1);
        while ($item_list_info1 = mysql_fetch_array($select_all_item_sql1)) {
            $list_item1[] = $item_list_info1;
        }
        return $list_item1;
    }

    ////////////////////////////ItemInfo Individula////////////////////////////////
    public function item_info_individual($val)
    {
        $this->Fconnection();
        $sql1 = "
SELECT
    `all_item_info`.item_tb_id,
    `all_item_info`.item_id,
    `all_item_info`.item_name,
    `all_item_info`.sub_group,
    `all_item_info`.sub_group_id,
    `all_item_info`.group_name,
    `all_item_info`.group_id,
    current_item_info_fainal.qty,
    current_item_info_fainal.unit,
    current_item_info_fainal.item_id,
    `all_item_info`.asset_typ
FROM
    `all_item_info`,
    current_item_info_fainal 
where
    `all_item_info`.item_tb_id=current_item_info_fainal.item_id 
    and `all_item_info`.item_name!='' 
    and all_item_info.item_tb_id='$val' limit 1 
        ";
        //echo $sql1;
        $select_all_item_sql1 = mysql_query("$sql1");
        $item_list_info1 = mysql_fetch_array($select_all_item_sql1);
        return $item_list_info1;
    }

    public function item_info_individual_infosarkar($val)
    {
        $this->Fconnection();
        $sql1 = "SELECT `all_item_info`.item_tb_id, `all_item_info`.item_id, `all_item_info`.item_name, `all_item_info`.sub_group, `all_item_info`.sub_group_id, `all_item_info`.group_name, `all_item_info`.group_id, current_item_info_fainal_infosarkar.qty, current_item_info_fainal_infosarkar.unit, current_item_info_fainal_infosarkar.item_id,`all_item_info`.item_code_inv FROM `all_item_info`,current_item_info_fainal_infosarkar where `all_item_info`.item_tb_id=current_item_info_fainal_infosarkar.item_id and `all_item_info`.item_name!='' and all_item_info.item_tb_id='$val' limit 1 ";
        //echo $sql1;
        $select_all_item_sql1 = mysql_query("$sql1");
        $item_list_info1 = mysql_fetch_array($select_all_item_sql1);
        return $item_list_info1;
    }

    public function item_info_individual_infosarkar_new($val)
    {
        $this->Fconnection();
        //$sql1="SELECT `all_item_info`.item_tb_id, `all_item_info`.item_id, `all_item_info`.item_name, `all_item_info`.sub_group, `all_item_info`.sub_group_id, `all_item_info`.group_name, `all_item_info`.group_id, current_item_info_fainal_infosarkar.qty, current_item_info_fainal_infosarkar.unit, current_item_info_fainal_infosarkar.item_id,`all_item_info`.item_code_inv FROM `all_item_info`,current_item_info_fainal_infosarkar where `all_item_info`.item_tb_id=current_item_info_fainal_infosarkar.item_id and `all_item_info`.item_name!='' and all_item_info.item_tb_id='$val' limit 1 ";
        $sql1 = "select item_name,item_name,qty ,unit,unit_price,total_value,item_tb_id,pr_id,item_id ,item_code_inv,huwaei_id_bom_no  from current_item_info_fainal_infosarkar where id = $val";

        //echo $sql1;
        $select_all_item_sql1 = mysql_query("$sql1");
        $item_list_info1 = mysql_fetch_array($select_all_item_sql1);
        return $item_list_info1;
    }


    public function item_info_individual_sum_infosarkar($val)
    {
        $this->Fconnection();
        $sql1 = "SELECT current_item_info_fainal_infosarkar.qty FROM current_item_info_fainal_infosarkar where current_item_info_fainal_infosarkar.item_id = $val[0] and current_item_info_fainal_infosarkar.mr_id = $val[1]";
        //echo $sql1;
        $select_all_item_sql1 = mysql_query("$sql1");
        $item_list_info1 = mysql_fetch_array($select_all_item_sql1);
        return $item_list_info1;
    }

    ////////////////////////////ItemInfo Individula////////////////////////////////
    ////////////////////////////ItemInfo Individula MI Total////////////////////////////////
    public function item_info_individual_mi_total($val, $mr_id, $item_tb_id)
    {
        $this->Fconnection();
        $sql1 = "SELECT item_id as item_tb_id, item_id, item_name, sub_group, sub_group_id, `group`, group_id, qty, unit, item_id as item_id1, item_code_inv,sum(request_qty) FROM current_item_info_fainal where item_id='$val' and tmp_table_row_id=$item_tb_id and mr_id='$mr_id' group by mr_id,item_id";
        //echo $sql1;
        $select_all_item_sql1 = mysql_query("$sql1");
        $item_list_info1 = mysql_fetch_array($select_all_item_sql1);
        return $item_list_info1;
    }


    public function item_info_individual_mi_total_infosarkar($val, $mr_id)
    {
        $this->Fconnection();
        $sql1 = "SELECT item_id as item_tb_id, item_id, item_name, sub_group, sub_group_id, `group`, group_id, qty, unit, item_id as item_id1, item_code_inv,sum(request_qty) FROM current_item_info_fainal_infosarkar where item_id='$val' and mr_id='$mr_id' group by mr_id,item_id";
        // echo $sql1;
        $select_all_item_sql1 = mysql_query("$sql1");
        $item_list_info1 = mysql_fetch_array($select_all_item_sql1);
        return $item_list_info1;
    }

    public function get_all_serial_item_info_individual_infosarkar($val, $mi_id)
    {
        $this->Fconnection();
        $sql1 = "SELECT serial_no  FROM infosarker3_serial_fainal where item_id='$val' and mi_id='$mi_id' ";
        //  echo $sql1;
        $select_all_item_sql1 = mysql_query("$sql1");
        return $select_all_item_sql1;
    }


    ////////////////////////////ItemInfo IndividulaMI Total////////////////////////////////
    ////////////////////////////ItemInfo Individula GR Total////////////////////////////////
    public function item_info_individual_gr_total($val, $po_id)
    {
        $this->Fconnection();
        $sql1 = "SELECT item_id as item_tb_id, item_id, item_name, sub_group, sub_group_id, `group`, group_id, qty, unit, item_id as item_id1, item_code_inv,sum(request_qty) FROM current_item_info_fainal where item_id='$val' and po_id='$po_id' group by po_id,item_id";
        //echo $sql1;
        $select_all_item_sql1 = mysql_query("$sql1");
        $item_list_info1 = mysql_fetch_array($select_all_item_sql1);
        return $item_list_info1;
    }

    public function item_info_individual_gr_total_infosarkar($val, $po_id)
    {
        $this->Fconnection();
        $sql1 = "SELECT item_id as item_tb_id, item_id, item_name, sub_group, sub_group_id, `group`, group_id, qty, unit, item_id as item_id1, item_code_inv,sum(request_qty) FROM current_item_info_fainal_infosarkar where item_id='$val' and po_id='$po_id' group by po_id,item_id";
        //echo $sql1;
        $select_all_item_sql1 = mysql_query("$sql1");
        $item_list_info1 = mysql_fetch_array($select_all_item_sql1);
        return $item_list_info1;
    }
    ////////////////////////////ItemInfo Individula GR Total////////////////////////////////
    ////////////////////////////ItemInfo Individula MI////////////////////////////////
    public function item_info_individual_mi($val, $mi_id)
    {
        $this->Fconnection();
        $sql1 = "SELECT item_id as item_tb_id, item_id, item_name, sub_group, sub_group_id, `group`, group_id, qty, unit, item_id as item_id1, item_code_inv,sum(request_qty) FROM current_item_info_fainal where item_id='$val' and mi_id='$mi_id'";

        $select_all_item_sql1 = mysql_query("$sql1");
        $item_list_info1 = mysql_fetch_array($select_all_item_sql1);
        return $item_list_info1;
    }
    ////////////////////////////ItemInfo IndividulaMI////////////////////////////////
    ///////////////////////////Current Inventory////////////////////////////////////
    public function inventory_update_info($statement)
    {
        $this->Fconnection();
        $sql1 = "select * from current_item_info_fainal where current_item_info_fainal.id in (select max(id) as id from current_item_info_fainal group by item_id) and current_item_info_fainal.item_code_inv!='' $statement order by id desc limit 1000";
        //echo $sql1;
        $select_all_item_sql1 = mysql_query("$sql1");
        while ($item_list_info1 = mysql_fetch_array($select_all_item_sql1)) {
            $list_item1[] = $item_list_info1;
        }
        return $list_item1;
    }
    ///////////////////////////////////////////////////////////////


    ///////////////////////////Current Inventory with pagination NEW2019////////////////////////////////////
    ///////////////////////////Current Inventory with pagination////////////////////////////////////
    public function inventory_update_info_pagination1($statement, $start_from, $num_rec_per_page)
    {
        //select * from current_item_info_fainal where current_item_info_fainal.id in (select max(id) as id from current_item_info_fainal group by item_id) and current_item_info_fainal.item_code_inv!=''  $statement order by id desc  LIMIT $start_from, $num_rec_per_page

//select * from current_item_info_fainal where current_item_info_fainal.id in (select max(id) as id from current_item_info_fainal group by item_id) and current_item_info_fainal.item_code_inv!=''  $statement order by id desc  LIMIT $start_from, $num_rec_per_page


        $this->Fconnection();
        //$sql1="select tt.item_name,tt.qty,tt.unit,tt.`group`,tt.main_group_account,tt.item_code_inv,tt.datei from current_item_info_fainal tt INNER JOIN (SELECT item_tb_id, MAX(id) AS id1 FROM current_item_info_fainal GROUP BY item_tb_id) cciif ON tt.item_tb_id = cciif.item_tb_id AND tt.id = cciif.id1 and tt.item_code_inv!=''  $statement order by id desc LIMIT $start_from, $num_rec_per_page";
        // echo $sql1;
        //$select_all_item_sql1=mysql_query("$sql1");

        //return $select_all_item_sql1;
        $sql_nldt = "SELECT MAX(id) FROM current_item_info_fainal where item_code_inv!=''  $statement GROUP BY item_tb_id order by item_name LIMIT $start_from, $num_rec_per_page";
        //echo $sql_nldt;
        $select_att_data_sql = mysql_query("$sql_nldt");
        while ($att_data = mysql_fetch_array($select_att_data_sql)) {
            $att[] = $att_data;
        }
        return $att;
    }

    public function inventory_update_info_item($id)
    {
        $this->Fconnection();
        $sql1 = "select tt.item_name,tt.qty,tt.unit,tt.`group`,tt.main_group_account,tt.item_code_inv,tt.datei from current_item_info_fainal as tt where id = '$id'";
        //echo $sql1;
        $select_all_item_sql1 = mysql_query("$sql1");
        $item_list_info1 = mysql_fetch_array($select_all_item_sql1);
        return $item_list_info1;
    }
    ///////////////////////////Current Inventory with pagination New2019////////////////////////////////////

    ///////////////////////////Current Inventory with pagination////////////////////////////////////
    public function inventory_update_info_pagination($statement, $start_from, $num_rec_per_page)
    {
        //select * from current_item_info_fainal where current_item_info_fainal.id in (select max(id) as id from current_item_info_fainal group by item_id) and current_item_info_fainal.item_code_inv!=''  $statement order by id desc  LIMIT $start_from, $num_rec_per_page

//select * from current_item_info_fainal where current_item_info_fainal.id in (select max(id) as id from current_item_info_fainal group by item_id) and current_item_info_fainal.item_code_inv!=''  $statement order by id desc  LIMIT $start_from, $num_rec_per_page


        $this->Fconnection();
        $sql1 = "select tt.item_name,tt.qty,tt.unit,tt.`group`,tt.main_group_account,tt.item_code_inv,tt.datei from current_item_info_fainal tt INNER JOIN (SELECT item_tb_id, MAX(id) AS id1 FROM current_item_info_fainal GROUP BY item_tb_id) cciif ON tt.item_tb_id = cciif.item_tb_id AND tt.id = cciif.id1 and tt.item_code_inv!=''  $statement order by id desc LIMIT $start_from, $num_rec_per_page";
        // echo $sql1;
        $select_all_item_sql1 = mysql_query("$sql1");

        return $select_all_item_sql1;
    }

    public function inventory_update_info_pagination_infosarkar($statement, $start_from, $num_rec_per_page)
    {
        $this->Fconnection();
        $sql1 = "select * from current_item_info_fainal_infosarkar where current_item_info_fainal_infosarkar.id in (select max(id) as 
id from current_item_info_fainal_infosarkar group by item_id) and current_item_info_fainal_infosarkar.item_code_inv!=''   $statement order by id desc  LIMIT 100 ";
        // echo $sql1;
        $select_all_item_sql1 = mysql_query("$sql1");

        return $select_all_item_sql1;
    }

    public function count_inventory_update_info()
    {
        $this->Fconnection();
        $sql1 = "select * from current_item_info_fainal_infosarkar where current_item_info_fainal_infosarkar.id in (select max(id) as id from current_item_info_fainal_infosarkar group by item_id) and current_item_info_fainal_infosarkar.item_code_inv!=''  order by id desc ";
        //echo $sql1;
        $select_all_item_sql1 = mysql_query("$sql1");
        $total_rows = mysql_num_rows($select_all_item_sql1);
        return $total_rows;
    }








    ///////////////////////////////////////////////////////////////


    /////////////////////Last PQ Item With Value//////////////////////////////////////////
    public function pq_item_info_ind($statement)
    {
        $this->Fconnection();
        $sql1 = "SELECT item_id,item_name,ordered_quantity,unit,price_per_unit,pq_id FROM pq_item_info WHERE pq_item_info.item_tb_id=$statement";
        //echo $sql1;
        $select_all_item_sql1 = mysql_query("$sql1");
        $item_list_info1 = mysql_fetch_row($select_all_item_sql1);
        return $item_list_info1;
    }

    public function inventory_last_pq_info($statement, $start_from, $num_rec_per_page)
    {
        $this->Fconnection();
        //$sql1="SELECT MAX(item_tb_id) FROM pq_item_info where pq_item_info.price_per_unit>0 $statement GROUP BY item_id ORDER BY item_name";
        $sql1 = "SELECT MAX(pq_item_info.item_tb_id) FROM pq_item_info,scm_approval_tree WHERE scm_approval_tree.pq_id=pq_item_info.pq_id AND scm_approval_tree.po_id!='' and pq_item_info.price_per_unit>0 $statement GROUP BY pq_item_info.item_id ORDER BY item_name LIMIT $start_from,$num_rec_per_page";
        //echo $sql1;
        $select_all_item_sql1 = mysql_query("$sql1");
        /*
     while($item_list_info1=mysql_fetch_array($select_all_item_sql1))
     {
       $list_item1[]=$item_list_info1;
     }
	 */
        return $select_all_item_sql1;
    }
    /////////////////////Last PQ Item With Value//////////////////////////////////////////


    ///////////////////////////PR TMP APPROVED PR Inventory////////////////////////////////////
    public function tmp_item_pr_info($statement)
    {
        $this->Fconnection();
        $sql1 = "SELECT * FROM tmp_item_info WHERE pr_id IN (SELECT pr_id FROM scm_approval_tree WHERE pr_approval_l3!='') and item_name1!=''  $statement order by pr_id";
        // echo $sql1;
        $select_all_item_sql1 = mysql_query("$sql1");
        while ($item_list_info1 = mysql_fetch_array($select_all_item_sql1)) {
            $list_item1[] = $item_list_info1;
        }
        return $list_item1;
    }

    ///////////////////////////////////////////////////////////////

    public function item_details_info($item_tb_id)
    {
        $this->Fconnection();
        $select_item_details_sql = mysql_query("SELECT `item_info`.item_tb_id,`item_info`.item_id,`item_info`.item_name,`item_info`.description,`item_info`.unit,
        `item_info`.price_per_unit,`item_info`.remarks,`item_info`.`status` FROM `item_info` where item_tb_id='$item_tb_id'");
        $item_info = mysql_fetch_array($select_item_details_sql);
        return $item_info;
    }

    public function total_po_list()
    {
        $this->Fconnection();
        $sql = "SELECT`po_info`.po_ref_no,`po_info`.vendor_tb_id,`po_info`.po_date,`po_info`.pr_id,`po_info`.delivery_terms,
     `po_info`.shipment_date,`po_info`.price,`po_info`.currency,`po_info`.fright_charge,`po_info`.warrenty,`po_info`.shipping_documents,`po_info`.blpcoo,
     `po_info`.payment_terms,`po_info`.payment_mode,`po_info`.delivery_date,`po_info`.delevery_place,`po_info`.delivery_status,`po_info`.po_approval_date,
     `po_info`.po_status FROM `po_info`  where po_tb_id<>0 order by po_tb_id desc";
        //echo $sql;
        $select_all_po_sql = mysql_query($sql);
        while ($po_list_info = mysql_fetch_array($select_all_po_sql)) {
            $list_po[] = $po_list_info;
        }
        return $list_po;
    }


//pagination function


    public function count_total_po_list()
    {
        $this->Fconnection();
        $sql = "SELECT `po_info`.po_ref_no,`po_info`.vendor_tb_id,`po_info`.po_date,`po_info`.pr_id,`po_info`.delivery_terms,
     `po_info`.shipment_date,`po_info`.price,`po_info`.currency,`po_info`.fright_charge,`po_info`.warrenty,`po_info`.shipping_documents,`po_info`.blpcoo,
     `po_info`.payment_terms,`po_info`.payment_mode,`po_info`.delivery_date,`po_info`.delevery_place,`po_info`.delivery_status,`po_info`.po_approval_date,
     `po_info`.po_status FROM `po_info`  where po_tb_id<>0 order by po_tb_id desc";
        //echo $sql;
        $select_all_po_sql = mysql_query($sql);
        $total_records = mysql_num_rows($select_all_po_sql);

        return $total_records;
    }


    public function total_po_list_pagination($start_from, $num_rec_per_page)
    {
        $this->Fconnection();
        $sql = "SELECT`po_info`.po_ref_no,`po_info`.vendor_tb_id,`po_info`.po_date,`po_info`.pr_id,`po_info`.delivery_terms,
     `po_info`.shipment_date,`po_info`.price,`po_info`.currency,`po_info`.fright_charge,`po_info`.warrenty,`po_info`.shipping_documents,`po_info`.blpcoo,
     `po_info`.payment_terms,`po_info`.payment_mode,`po_info`.delivery_date,`po_info`.delevery_place,`po_info`.delivery_status,`po_info`.po_approval_date,
     `po_info`.po_status FROM `po_info`  where po_tb_id<>0 order by po_tb_id desc  LIMIT $start_from, $num_rec_per_page";
        // echo $sql;
        $select_all_po_sql = mysql_query($sql);

        return $select_all_po_sql;
    }

    //


    public function pr_auto_gen_()
    {
        $this->Fconnection();
        $today = date("Y-m-d");
        $val = $_SESSION['employee_id'];
        //$max="select max(id) from  client_info
        $pr_gen_max = mysql_query("select max(pr_tb_id) from  pr_info1");
        $pr_max_no = mysql_fetch_row($pr_gen_max);
        $a = $pr_max_no[0] + 1;
        $increment_value_pr = 'FAHSC' . $val . $today . 'PR' . $a;
        return $increment_value_pr;
    }

    public function pr_auto_gen_temp()
    {
        $this->Fconnection();
        $today = date("Y-m-d");
        $val = $_SESSION['employee_id'];
        //$max="select max(id) from  client_info
        $pr_gen_max = mysql_query("select max(pr_tb_id) from  pr_info1_temp");
        $pr_max_no = mysql_fetch_row($pr_gen_max);
        $a = $pr_max_no[0] + 1;
        $increment_value_pr = 'FAHSC' . $val . $today . 'PR' . $a;
        return $increment_value_pr;
    }

    public function pr_auto_gen_split_purpose($var)
    {
        $this->Fconnection();
        $today = date("Y-m-d");
        $val = $_SESSION['employee_id'];
        //$max="select max(id) from  client_info
        $pr_gen_max = mysql_query("select pr_tb_id,pr_id from  pr_info1 where pr_id like '$var%' order by pr_tb_id desc");
        $pr_max_no = mysql_fetch_row($pr_gen_max);
//get pr_tb_id
        $a = $pr_max_no[1];
//explode
        $exploded = explode('-', $pr_max_no[1]);
//get last part from explode
        $last_partd = end($exploded);

//minus last digit from last part
        $last_char = substr($last_partd, -1);
//check is it digit
        if (ctype_digit($last_char)) {
            $char_increment = 'A';
            $increment_value_pr = $a . $char_increment;
        } else {
            $char_increment = ++$last_char;

            $pr_with_del_last_string = substr($a, 0, -1);
            $increment_value_pr = $pr_with_del_last_string . $char_increment;
        }


        // $increment_value_pr='FAHSC'.$val.$today.'PR'.$a.$char_increment;

        return $increment_value_pr;
    }


    public function mri_auto_gen_()
    {
        $this->Fconnection();
        $today = date("Y-m-d");
        $val = $_SESSION['employee_id'];
        //$max="select max(id) from  client_info
        $pr_gen_max = mysql_query("select max(pr_tb_id) from  pr_info1");
        $pr_max_no = mysql_fetch_row($pr_gen_max);
        $a = $pr_max_no[0] + 1;
        $increment_value_pr = 'FAHSC' . $val . $today . 'MRI' . $a;
        return $increment_value_pr;
    }

    public function pr_terms($values)
    {
        $this->Fconnection();
        $today = date("Y-m-d");
        $inser_pr_terms = mysql_query("insert into pr_info4 (pr_tb_id,meterial_avalability,options_aulternat_meterials,justification,vendor_id,delivery_date,payment_terms,
     remarks,`status`,user) values ('$values[0]','$values[1]','$values[2]','$values[3]','$values[4]','$values[5]','$values[6]','$values[7]','$values[8]')");

        $insert_sql = mysql_fetch_array("$insert_sql");
        return $insert_sql;
    }

    ////////////////03-06-2014/////////////PR Revie and Edit////////////////////////////////
    public function pr0_review($values)
    {
        $this->Fconnection();
        $today = date("Y-m-d");
        $pr0_sql = "update scm_approval_tree set pr_31='$values[1]' where pr_id='$values[0]'";
        //echo $pr0_sql;
        $pr0_add_sql = mysql_query("$pr0_sql");

        $review_pr0_sql = mysql_fetch_array("$pr0_add_sql");
        return $review_pr0_sql;
    }


    public function pr0_edit_info($values)
    {
        $this->Fconnection();
        $today = date("Y-m-d");
        //$pr0_edit_info_sql1="update scm_approval_tree set pr_31='$values[1]' where pr_id='$values[0]'";
        $pr0_edit_info_sql1 = "update $values[16] set pr_type='$values[1]',pr_date='$values[2]',pr_by='$values[3]',pr_porpuse='$values[4]',expense_type='$values[5]',meterial_type='$values[6]',total_estimated_cost='$values[7]',delivery_instruction='$values[8]',remarks='$values[9]',license_id='$values[10]',co_id='$values[11]',project_id='$values[12]',project_id_new='$values[13]',project_id_new_for='$values[14]',exp_description='$values[15]' where pr_id='$values[0]' and pr_id!=''";

        //  echo $pr0_edit_info_sql1;
        $pr0_edit_info = mysql_query("$pr0_edit_info_sql1");

        $pr0_edit_info_sql = mysql_fetch_array("$pr0_edit_info");
        return $pr0_edit_info_sql;
    }


    public function pr_temp_item_info_edit($values, $table_tmp_item_info_temp)
    {
        $this->Fconnection();
        $today = date("Y-m-d");

        $sql = mysql_query("SELECT *  FROM  all_item_info WHERE item_id = '$values[6]'");
        // echo "SELECT *  FROM  all_item_info WHERE item_id = '$value_item_name[$i]'";
        $unit_val = mysql_fetch_row($sql);


        $pr_temp_item_info_edit = "update $table_tmp_item_info_temp set item_name='$values[0]',description='$values[1]',ordered_quantity=$values[2],unit='$unit_val[9]',vat='$values[5]',date='$today',item_id='$values[0]' where pr_id='$values[4]' and item_name='$values[6]'  and item_tb_id='$values[7]'";
        // echo $pr_temp_item_info_edit;
        $pr_temp_item_info_edit_q = mysql_query($pr_temp_item_info_edit);

        // $pr_temp_item_info_edit_sql= mysql_fetch_array("$pr_temp_item_info_edit_q");
        return $pr_temp_item_info_edit_q;
    }


    ////////////////03-06-2014///////////// pr_info1_temp  PR Revie and Edit//////////////////////////////// adba

    public function mrir0_add_info($values)
    {
        $this->Fconnection();
        $today = date("Y-m-d");
        $pr0_sql = "insert into pr_info1 (pr_id,pr_type,pr_date,pr_by,pr_porpuse,expense_type,meterial_type,total_estimated_cost,delivery_instruction,remarks,license_id,co_id)
values ('$values[0]','$values[1]','$values[2]','$values[3]','$values[4]','$values[5]','$values[6]','$values[7]','$values[8]','$values[9]','$values[10]','$values[11]')";
//echo $pr0_sql;
        $pr0_add_sql = mysql_query("$pr0_sql");
        $insert_pr0_sql = mysql_fetch_array("$pr0_add_sql");
        return $insert_pr0_sql;
    }

    public function pr0_total_count($pr_id)
    {
        $this->Fconnection();
        $today = date("Y-m-d");
        $sql = "select SUM(tmp_item_info.total_value)  from tmp_item_info where pr_id='$pr_id'";
        //echo $sql;
        $sql_total = mysql_query("$sql");
        $total_count = mysql_fetch_row($sql_total);
        $total_count_vat = $total_count[0] * (0.15);
        $total_count_vat_includ = $total_count[0] + $total_count_vat;
        $pr_count_total = array($total_count[0], $total_count_vat, $total_count_vat_includ);
        return $pr_count_total;
    }

    ////////////////////15-04-2014///////////////////
    public function pr0_count($pr_id)
    {
        $this->Fconnection();
        $today = date("Y-m-d");
        $sql = "select sum(tmp_item_info.id)  from tmp_item_info where pr_id='$pr_id'";
        //echo $sql;
        $sql_total = mysql_query("$sql");
        $total_count = mysql_fetch_row($sql_total);
        return $total_count;
    }

    /////////////////////////////////////////////////////
    public function pr1_add_info($values)
    {
        $this->Fconnection();
        $today = date("Y-m-d");
        $pr1_add_sql = mysql_query("insert into pr_info2 (pr_tb_id,item_tb_id,specification,item_qty,item_uom,estimated_unit_price,remarks,`status`,estimated_total_price)
                values ('$values[0]','$values[1]','$values[2]','$values[3]','$values[4]','$values[5]','$values[6]','$values[7]','$values[8]')");

        $insert_pr1_sql = mysql_fetch_array("$pr1_add_sql");
        return $insert_pr1_sql;
    }


    public function pr_p0_gridview_pagination($statement, $start_from, $num_rec_per_page)
    {
        $this->Fconnection();
        $sql = "SELECT pr_id,pr_type,pr_date,pr_porpuse,expense_type,meterial_type,total_estimated_cost,delivery_instruction,remarks,pr_by,license_id,co_id FROM pr_info1 where pr_tb_id<>0 $statement ORDER BY pr_tb_id  LIMIT $start_from, $num_rec_per_page";
        // echo "SELECT pr_id,pr_type,pr_date,pr_porpuse,expense_type,meterial_type,total_estimated_cost,delivery_instruction,remarks,pr_by,license_id,co_id FROM pr_info1 where pr_tb_id<>0 $statement ORDER BY pr_tb_id  LIMIT $start_from, $num_rec_per_page" ;
        $select_pr_p0_gridview = mysql_query("$sql");

        return $select_pr_p0_gridview;
    }


    public function pr_p0_gridview($statement)
    {
        $this->Fconnection();
        $sql = "SELECT pr_id,pr_type,pr_date,pr_porpuse,expense_type,meterial_type,total_estimated_cost,delivery_instruction,remarks,pr_by,license_id,co_id FROM pr_info1 where pr_tb_id<>0 $statement order by pr_tb_id desc";
        //echo $sql;
        $select_pr_p0_gridview = mysql_query("$sql");
        while ($pr_p0_gridview_list = mysql_fetch_array($select_pr_p0_gridview)) {
            $pr_p0_gridview[] = $pr_p0_gridview_list;
        }
        return $pr_p0_gridview;
    }

    /////////////////SCMAdmin/////////////////////////
    public function pr_p0_gridview_admin($statement)
    {
        $this->Fconnection();
        $sql = "SELECT pr_info1.pr_id,pr_info1.pr_type,pr_info1.pr_date,pr_info1.pr_porpuse,pr_info1.expense_type,pr_info1.meterial_type,pr_info1.total_estimated_cost,pr_info1.delivery_instruction,pr_info1.remarks,pr_info1.pr_by,pr_info1.license_id,pr_info1.co_id FROM pr_info1,scm_approval_tree where pr_info1.pr_id=scm_approval_tree.pr_id and pr_info1.pr_tb_id<>0 $statement order by pr_info1.pr_tb_id desc";
        //echo $sql;
        $select_pr_p0_gridview = mysql_query("$sql");
        while ($pr_p0_gridview_list = mysql_fetch_array($select_pr_p0_gridview)) {
            $pr_p0_gridview[] = $pr_p0_gridview_list;
        }
        return $pr_p0_gridview;
    }

    /////////////////SCMAdmin/////////////////////////


/////////////////SCMAdmin with pagination/////////////////////////
    public function pr_p0_gridview_admin_pagination($statement, $start_from, $num_rec_per_page)
    {
        $this->Fconnection();
        $sql = "SELECT pr_info1.pr_id,pr_info1.pr_type,pr_info1.pr_date,pr_info1.pr_porpuse,pr_info1.expense_type,pr_info1.meterial_type,pr_info1.total_estimated_cost,pr_info1.delivery_instruction,pr_info1.remarks,pr_info1.pr_by,pr_info1.license_id,pr_info1.co_id FROM pr_info1,scm_approval_tree where pr_info1.pr_id=scm_approval_tree.pr_id and pr_info1.pr_tb_id<>0 $statement order by pr_info1.pr_tb_id desc LIMIT $start_from, $num_rec_per_page";
        //echo $sql;
        $select_pr_p0_gridview = mysql_query("$sql");

        return $select_pr_p0_gridview;
    }


    public function count_pr_p0_gridview_admin_pagination()
    {
        $this->Fconnection();
        $sql = "SELECT pr_info1.pr_id,pr_info1.pr_type,pr_info1.pr_date,pr_info1.pr_porpuse,pr_info1.expense_type,pr_info1.meterial_type,pr_info1.total_estimated_cost,pr_info1.delivery_instruction,pr_info1.remarks,pr_info1.pr_by,pr_info1.license_id,pr_info1.co_id FROM pr_info1,scm_approval_tree where pr_info1.pr_id=scm_approval_tree.pr_id and pr_info1.pr_tb_id<>0 $statement order by pr_info1.pr_tb_id desc";
        //echo $sql;
        $select_pr_p0_gridview = mysql_query("$sql");
        $total_records = mysql_num_rows($select_pr_p0_gridview);
        return $total_records;
    }


    /////////////////SCMAdmin/////////////////////////


    public function pr_p0_gridview_adminuser($statement, $start_from, $num_rec_per_page)
    {
        $this->Fconnection();
        //$sql="SELECT pr_info1.pr_id,pr_info1.pr_type,pr_info1.pr_date,pr_info1.pr_porpuse,pr_info1.expense_type,pr_info1.meterial_type,pr_info1.total_estimated_cost,pr_info1.delivery_instruction,pr_info1.remarks,pr_info1.pr_by,pr_info1.license_id,pr_info1.co_id,pr_info1.project_id FROM pr_info1,scm_approval_tree where pr_info1.pr_id=scm_approval_tree.pr_id  and scm_approval_tree.pr_approval_l2!='' and pr_info1.pr_tb_id<>0 $statement  LIMIT $start_from, $num_rec_per_page" ;
        $sql = "
SELECT
    pr_info1.pr_id,
    pr_info1.pr_type,
    pr_info1.pr_date,
    pr_info1.pr_porpuse,
    pr_info1.expense_type,
    pr_info1.meterial_type,
    pr_info1.total_estimated_cost,
    pr_info1.delivery_instruction,
    pr_info1.remarks,
    pr_info1.pr_by,
    pr_info1.license_id,
    pr_info1.co_id,
    pr_info1.project_id 
FROM
    pr_info1,
    scm_approval_tree 
where
    pr_info1.pr_id=scm_approval_tree.pr_id  
    and scm_approval_tree.pr_approval_l2!='' 
    and scm_approval_tree.cancel_status = 0 
    and pr_info1.pr_tb_id<>0 $statement  LIMIT $start_from, $num_rec_per_page
        
        ";


        //echo $sql;
        // if($_SESSION['employee_id'] == '02-1606'){   echo $sql;}

        $select_pr_p0_gridview = mysql_query("$sql");
        while ($pr_p0_gridview_list = mysql_fetch_array($select_pr_p0_gridview)) {
            $pr_p0_gridview[] = $pr_p0_gridview_list;
        }
        return $pr_p0_gridview;
    }

    public function pr_p0_gridview_adminuser_manual_po($statement, $start_from, $num_rec_per_page)
    {
        $this->Fconnection();
        //$sql="SELECT pr_info1.pr_id,pr_info1.pr_type,pr_info1.pr_date,pr_info1.pr_porpuse,pr_info1.expense_type,pr_info1.meterial_type,pr_info1.total_estimated_cost,pr_info1.delivery_instruction,pr_info1.remarks,pr_info1.pr_by,pr_info1.license_id,pr_info1.co_id,pr_info1.project_id FROM pr_info1,scm_approval_tree where pr_info1.pr_id=scm_approval_tree.pr_id  and scm_approval_tree.pr_approval_l2!='' and pr_info1.pr_tb_id<>0 $statement  LIMIT $start_from, $num_rec_per_page" ;
        $sql = "
SELECT
    scm_approval_tree.* 
FROM
    scmv3.pr_info1,
    scmv3.scm_approval_tree 
WHERE
    pr_info1.pr_id = scm_approval_tree.pr_id   
    AND pr_info1.pr_date < '2016-01-01 00:00:00'   
    AND pr_approval_l1 IS NOT NULL   
    AND pr_approval_l2 IS NOT NULL   
    AND pr_approval_l3 IS NOT NULL   
    AND scm_approval_tree.cancel_status != 1   
    AND scm_approval_tree.pq_id IS NULL 
    $statement
      
        ";


        $sqlWithStatusCancel = "
SELECT
    scm_approval_tree.* 
FROM
    scmv3.pr_info1,
    scmv3.scm_approval_tree 
WHERE
    pr_info1.pr_id = scm_approval_tree.pr_id   
    AND scm_approval_tree.cancel_status = 2   
    $statement
        ";


        //echo $sql;
        // if($_SESSION['employee_id'] == '02-1606'){   echo $sql;}

        $select_pr_p0_gridview = mysql_query("$sqlWithStatusCancel");
        while ($pr_p0_gridview_list = mysql_fetch_array($select_pr_p0_gridview)) {
            $pr_p0_gridview[] = $pr_p0_gridview_list;
        }
        return $pr_p0_gridview;
    }

    public function pr_p0_gridview_adminuser_grn_page($statement, $start_from, $num_rec_per_page)
    {
        $this->Fconnection();
        $sql = "SELECT pr_info1.pr_id,pr_info1.pr_type,pr_info1.pr_date,pr_info1.pr_porpuse,pr_info1.expense_type,pr_info1.meterial_type,pr_info1.total_estimated_cost,pr_info1.delivery_instruction,pr_info1.remarks,pr_info1.pr_by,pr_info1.license_id,pr_info1.co_id,pr_info1.project_id FROM pr_info1,scm_approval_tree where pr_info1.pr_id=scm_approval_tree.pr_id  and pr_info1.project_id !='INF03' and pr_info1.pr_tb_id<>0 $statement order by pr_info1.pr_date desc LIMIT $start_from,$num_rec_per_page";
        //echo $sql;
        $select_pr_p0_gridview = mysql_query("$sql");
        /*
     while($pr_p0_gridview_list=mysql_fetch_array($select_pr_p0_gridview))
     {
       $pr_p0_gridview[]=$pr_p0_gridview_list;
     }
	 */
        return $select_pr_p0_gridview;
    }


    public function pr_p0_gridview_adminuser_infosarkar($statement)
    {
        $this->Fconnection();
        $sql = "SELECT pr_info1.pr_id,pr_info1.pr_type,pr_info1.pr_date,pr_info1.pr_porpuse,pr_info1.expense_type,pr_info1.meterial_type,pr_info1.total_estimated_cost,pr_info1.delivery_instruction,pr_info1.remarks,pr_info1.pr_by,pr_info1.license_id,pr_info1.co_id,pr_info1.project_id FROM pr_info1,scm_approval_tree where pr_info1.pr_id=scm_approval_tree.pr_id  and pr_info1.project_id='INF03' and pr_info1.pr_tb_id<>0 $statement order by pr_info1.pr_date desc";
        // echo $sql;
        $select_pr_p0_gridview = mysql_query("$sql");
        while ($pr_p0_gridview_list = mysql_fetch_array($select_pr_p0_gridview)) {
            $pr_p0_gridview[] = $pr_p0_gridview_list;
        }
        return $pr_p0_gridview;
    }

    /////////////////Admin/////////////////////////
    /////////////////SCMAdmin/////////////////////////
    public function pr_p0_gridview_adminuser_report($statement)
    {
        $this->Fconnection();
        $sql = "SELECT scm_approval_tree.pr_id,scm_approval_tree.pr_by,scm_approval_tree.pr_approval_l2,scm_approval_tree.pr_approval_l2_date,scm_approval_tree.pr_approval_l3,scm_approval_tree.pr_approval_l3_date, scm_approval_tree.pq_id,scm_approval_tree.pq_by,scm_approval_tree.pq_date,scm_approval_tree.po_id,scm_approval_tree.po_by,scm_approval_tree.po_date,pq_item_info.item_id,pq_item_info.item_name,pq_item_info.description,pq_item_info.unit,pq_item_info.ordered_quantity,pq_item_info.price_per_unit,pq_item_info.total_value FROM pq_item_info,scm_approval_tree WHERE pq_item_info.pr_id=scm_approval_tree.pr_id AND scm_approval_tree.pr_approval_l3!='' and pq_item_info.pq_id=scm_approval_tree.pq_id $statement order by scm_approval_tree.id desc";
        //echo $sql;
        $select_pr_p0_gridview = mysql_query("$sql");
        while ($pr_p0_gridview_list = mysql_fetch_array($select_pr_p0_gridview)) {
            $pr_p0_gridview[] = $pr_p0_gridview_list;
        }
        return $pr_p0_gridview;
    }

    public function pq_item_info_item_details_info($vendor_tb_id)
    {
        $this->Fconnection();
        $select_vendor_details_sql = mysql_query("Select * from `pq_item_info` where pq_id=trim('$vendor_tb_id[0]') and item_id =$vendor_tb_id[1]");
//echo "Select * from `pq_item_info` where pq_id=trim('$vendor_tb_id[0]') and item_id =$vendor_tb_id[1]";

        $vendor_info = mysql_fetch_array($select_vendor_details_sql);
        return $vendor_info;
    }


    public function pr_p0_gridview_adminuser_report_laptop_desktop($statement)
    {
        $this->Fconnection();
        $sql = "SELECT scm_approval_tree.pr_id,
     scm_approval_tree.pr_by,
     scm_approval_tree.pr_approval_l2,
     scm_approval_tree.pr_approval_l2_date
     ,scm_approval_tree.pr_approval_l3,
     scm_approval_tree.pr_approval_l3_date,
      scm_approval_tree.pq_id,
      scm_approval_tree.pq_by,
      scm_approval_tree.pq_date,
      scm_approval_tree.po_id,
      scm_approval_tree.po_by,
      scm_approval_tree.po_date,
tmp_item_info.item_id,
tmp_item_info.item_name,
tmp_item_info.description,
tmp_item_info.unit,
tmp_item_info.ordered_quantity,scm_approval_tree.pq_forwarded_to FROM tmp_item_info,scm_approval_tree WHERE tmp_item_info.pr_id=scm_approval_tree.pr_id and scm_approval_tree.pr_approval_l2 !='' and tmp_item_info.group_id in(16,71)  $statement  order by scm_approval_tree.pr_approval_l3_date desc";
        //echo $sql;
        $select_pr_p0_gridview = mysql_query("$sql");
        while ($pr_p0_gridview_list = mysql_fetch_array($select_pr_p0_gridview)) {
            $pr_p0_gridview[] = $pr_p0_gridview_list;
        }
        return $pr_p0_gridview;
    }


    /////////////////Admin/////////////////////////
    public function pr_p0_gridview_user($statement, $val, $start_from, $num_rec_per_page)
    {
        $this->Fconnection();
        $sql = "SELECT pr_id,pr_type,pr_date,pr_porpuse,expense_type,meterial_type,total_estimated_cost,delivery_instruction,remarks,pr_by,license_id,co_id FROM pr_info1
     where (tbl_tier.employee_id='$val' or  tbl_tier.tr1='$val' or  tbl_tier.tr2='$val' or tbl_tier.tr3='$val' or  tbl_tier.tr4='$val' or  tbl_tier.tr5='$val') and pr_tb_id<>0
     $statement order by pr_tb_id desc";
        //echo $sql;
        $sql1 = "
SELECT
    pr_info1.pr_id,
    pr_info1.pr_type,
    pr_info1.pr_date,
    pr_info1.pr_porpuse,
    pr_info1.expense_type,
    pr_info1.meterial_type,
    pr_info1.total_estimated_cost,
    pr_info1.delivery_instruction,
    pr_info1.remarks,
    pr_by,
    pr_info1.license_id,
    pr_info1.co_id,
    `pr_info1`.pr_verify_by,
    `pr_info1`.pr_verify_date,
    `pr_info1`.pr_approve_by,
    `pr_info1`.pr_approval_date,
    `tbl_tier`.employee_id 
FROM
    `pr_info1`,
    tbl_tier,
    tmp_item_info 
where
    pr_info1.pr_id=tmp_item_info.pr_id  
    and `pr_info1`.pr_by = tbl_tier.employee_id 
    and (
        tbl_tier.employee_id='$val' 
        or  tbl_tier.tr1='$val' 
        or  tbl_tier.tr2='$val' 
        or tbl_tier.tr3='$val' 
        or  tbl_tier.tr4='$val' 
        or  tbl_tier.tr5='$val' 
        or tbl_tier.deligation='$val'
    ) 
    and `pr_info1`.pr_tb_id<>0   $statement 
group by
    pr_info1.pr_id 
order by
    `pr_info1`.pr_tb_id desc LIMIT $start_from,
    $num_rec_per_page
    
";
//echo $sql1;
        $select_pr_p0_gridview = mysql_query("$sql1");

        return $select_pr_p0_gridview;
    }


    public function pr_p0_gridview_user_infosarkar($statement, $val, $start_from, $num_rec_per_page)
    {
        $this->Fconnection();
        $sql = "SELECT pr_id,pr_type,pr_date,pr_porpuse,expense_type,meterial_type,total_estimated_cost,delivery_instruction,remarks,pr_by,license_id,co_id FROM pr_info1
     where (tbl_tier.employee_id='$val' or  tbl_tier.tr1='$val' or  tbl_tier.tr2='$val' or tbl_tier.tr3='$val' or  tbl_tier.tr4='$val' or  tbl_tier.tr5='$val') and pr_tb_id<>0
     $statement order by pr_tb_id desc";
        //echo $sql;
        $sql1 = "
SELECT
    pr_info1.pr_id,
    pr_info1.pr_type,
    pr_info1.pr_date,
    pr_info1.pr_porpuse,
    pr_info1.expense_type,
    pr_info1.meterial_type,
    pr_info1.total_estimated_cost,
    pr_info1.delivery_instruction,
    pr_info1.remarks,
    pr_info1.pr_by,
    pr_info1.license_id,
    pr_info1.co_id,
    `pr_info1`.pr_verify_by,
    `pr_info1`.pr_verify_date,
    `pr_info1`.pr_approve_by,
    `pr_info1`.pr_approval_date,
    `tbl_tier`.employee_id 
FROM
    `pr_info1`,
    tbl_tier,
    tmp_item_info 
where
    pr_info1.pr_id=tmp_item_info.pr_id  
    and `pr_info1`.pr_by = `tbl_tier`.employee_id 
    and (
        tbl_tier.employee_id='$val' 
        or  tbl_tier.tr1='$val' 
        or  tbl_tier.tr2='$val' 
        or tbl_tier.tr3='$val' 
        or  tbl_tier.tr4='$val' 
        or  tbl_tier.tr5='$val' 
        or tbl_tier.deligation='$val'
    ) 
    and `pr_info1`.pr_tb_id<>0 
    AND  `pr_info1`.project_id ='INF03' $statement 
group by
    pr_info1.pr_id 
order by
    `pr_info1`.pr_tb_id desc LIMIT $start_from,
    $num_rec_per_page
";
//echo $sql1;
        $select_pr_p0_gridview = mysql_query("$sql1");
        /*
     while($pr_p0_gridview_list=mysql_fetch_array($select_pr_p0_gridview))
     {
       $pr_p0_gridview[]=$pr_p0_gridview_list;
     }
	 */
        return $select_pr_p0_gridview;
    }


    public function pr_p0_gridview_user_infosarkar_d($statement, $val)
    {
        $this->Fconnection();
        $sql = "SELECT pr_id,pr_type,pr_date,pr_porpuse,expense_type,meterial_type,total_estimated_cost,delivery_instruction,remarks,pr_by,license_id,co_id FROM pr_info1
     where (tbl_tier.employee_id='$val' or  tbl_tier.tr1='$val' or  tbl_tier.tr2='$val' or tbl_tier.tr3='$val' or  tbl_tier.tr4='$val' or  tbl_tier.tr5='$val') and pr_tb_id<>0
     $statement order by pr_tb_id desc";
        //echo $sql;
        $sql1 = "SELECT
  pr_info1.pr_id,
  pr_info1.pr_type,
  pr_info1.pr_date,
  pr_info1.pr_porpuse,
  pr_info1.expense_type,
  pr_info1.meterial_type,
  pr_info1.total_estimated_cost,
  pr_info1.delivery_instruction,
  pr_info1.remarks,pr_info1.pr_by,
  pr_info1.license_id,
  pr_info1.co_id,
  `pr_info1`.pr_verify_by,
  `pr_info1`.pr_verify_date,
  `pr_info1`.pr_approve_by,
  `pr_info1`.pr_approval_date
FROM
  `pr_info1`,tmp_item_info
where pr_info1.pr_id=tmp_item_info.pr_id   and `pr_info1`.pr_tb_id<>0 AND  `pr_info1`.project_id ='INF03' $statement group by pr_info1.pr_id order by `pr_info1`.pr_tb_id desc";
//echo $sql1;
        $select_pr_p0_gridview = mysql_query("$sql1");
        while ($pr_p0_gridview_list = mysql_fetch_array($select_pr_p0_gridview)) {
            $pr_p0_gridview[] = $pr_p0_gridview_list;
        }
        return $pr_p0_gridview;
    }


    public function pr_p0_gridview_user_save($statement, $val)
    {
        $this->Fconnection();
        $sql = "SELECT pr_id,pr_type,pr_date,pr_porpuse,expense_type,meterial_type,total_estimated_cost,delivery_instruction,remarks,pr_by,license_id,co_id FROM pr_info1_temp
     where (tbl_tier.employee_id='$val' or  tbl_tier.tr1='$val' or  tbl_tier.tr2='$val' or tbl_tier.tr3='$val' or  tbl_tier.tr4='$val' or  tbl_tier.tr5='$val') and pr_tb_id<>0
     $statement order by pr_tb_id desc";
        //echo $sql;
        $sql1 = "SELECT
  pr_info1_temp.pr_id,
  pr_info1_temp.pr_type,
  pr_info1_temp.pr_date,
  pr_info1_temp.pr_porpuse,
  pr_info1_temp.expense_type,
  pr_info1_temp.meterial_type,
  pr_info1_temp.total_estimated_cost,
  pr_info1_temp.delivery_instruction,
  pr_info1_temp.remarks,pr_by,
  pr_info1_temp.license_id,
  pr_info1_temp.co_id,
  `pr_info1_temp`.pr_verify_by,
  `pr_info1_temp`.pr_verify_date,
  `pr_info1_temp`.pr_approve_by,
  `pr_info1_temp`.pr_approval_date,
  `tbl_tier`.employee_id
FROM
  `pr_info1_temp`,tbl_tier
where `pr_info1_temp`.pr_by = `tbl_tier`.employee_id
and (tbl_tier.employee_id='$val' or  tbl_tier.tr1='$val' or  tbl_tier.tr2='$val' or tbl_tier.tr3='$val' or  tbl_tier.tr4='$val' or  tbl_tier.tr5='$val' or tbl_tier.deligation='$val') and `pr_info1_temp`.pr_tb_id<>0 $statement group by pr_info1_temp.pr_id order by `pr_info1_temp`.pr_tb_id desc";
//echo $sql1;
        $select_pr_p0_gridview = mysql_query("$sql1");
        while ($pr_p0_gridview_list = mysql_fetch_array($select_pr_p0_gridview)) {
            $pr_p0_gridview[] = $pr_p0_gridview_list;
        }
        return $pr_p0_gridview;
    }

    public function pr_p0_view_($pr_id, $table_pr_info1)
    {
        $this->Fconnection();
        //$pr_p0_details_sql=mysql_query("SELECT pr_id,pr_type,pr_date,pr_porpuse,expense_type,meterial_type,total_estimated_cost,delivery_instruction,remarks,pr_by,license_id,co_id FROM pr_info1 where pr_id='$pr_id'");
        $sql = "
SELECT
    pr_id,
    pr_type,
    pr_date,
    pr_porpuse,
    expense_type,
    meterial_type,
    total_estimated_cost,
    delivery_instruction,
    remarks,
    pr_by,
    license_id,
    co_id,
    project_id,
    project_id_new,
    project_id_new_for,
    exp_description,
    uploaded_file 
FROM
    $table_pr_info1 
where
    pr_id='$pr_id'";
        //  echo $sql;
        $pr_p0_details_sql = mysql_query($sql);
        $pr_p0_info = mysql_fetch_array($pr_p0_details_sql);
        return $pr_p0_info;
    }

    public function pr_p1_view($pr_id)
    {
        $this->Fconnection();
        $sql_q = "SELECT item_name,description,ordered_quantity,unit,price_per_unit,total_value,item_tb_id,pr_id FROM tmp_item_info where pr_id='$pr_id'";
        //echo $sql_q;
        $pr_p1_details_sql = mysql_query("$sql_q");
        while ($pr_p1_info = mysql_fetch_array($pr_p1_details_sql)) {
            $pr_p1_view[] = $pr_p1_info;
        }
        return $pr_p1_info;
    }

    public function pr_p0_p1_view_($pr_id)
    {
        $this->Fconnection();
        $sql = "SELECT pr_id,tb_s1,tb_s2,tb_s3,tb_s4,tb_s5,tb_s6,tb_s7,tb_s8,tb_s9,tb_s10,tb_s11,tb_s12,comments,`status`,user,comments2 FROM pr_info3 where pr_id='$pr_id'";
        //echo $sql;
        $pr_p0_p1_details_sql = mysql_query("$sql");
        $pr_p0_p1_info = mysql_fetch_array($pr_p0_p1_details_sql);
        return $pr_p0_p1_info;
    }

    public function pr2_add_info($values)
    {
        $this->Fconnection();
        $today = date("Y-m-d");
        $sql_query = "insert into pr_info3 (pr_id,tb_s1,tb_s2,tb_s3,tb_s4,tb_s5,tb_s6,tb_s7,tb_s8,tb_s9,tb_s10,tb_s11,tb_s12,comments,`status`,user)
values ('$values[0]','$values[1]','$values[2]','$values[3]','$values[4]','$values[5]','$values[6]','$values[7]','$values[8]','$values[9]','$values[10]','$values[11]','$values[12]','$values[13]','$values[14]','$values[15]')";
//echo $sql_query;
        $pr2_add_sql = mysql_query("$sql_query");

        // $insert_pr2_sql= mysql_fetch_array($pr2_add_sql);
        //return $insert_pr2_sql;


        $info = mysql_insert_id();
        return $info;

    }


    public function pr0_add_info($values)
    {
        $this->Fconnection();
        $today = date("Y-m-d H:i:s");
        $pr0_sql = "insert 
into
    $values[17] (
        pr_id,pr_type,pr_date,pr_by,pr_porpuse,expense_type,meterial_type,total_estimated_cost,delivery_instruction,remarks,license_id,co_id,project_id,uploaded_file,project_id_new,project_id_new_for,exp_description
    ) 
values
    ('$values[0]','$values[1]','$values[2]','$values[3]','$values[4]','$values[5]','$values[6]','$values[7]','$values[8]','$values[9]','$values[10]','$values[11]','$values[12]','$values[13]','$values[14]','$values[15]','$values[16]')
        
        ";

//echo $pr0_sql;
        $pr0_add_sql = mysql_query("$pr0_sql");
        $insert_pr0_sql = mysql_fetch_array("$pr0_add_sql");
        return $insert_pr0_sql;
    }

    public function pr0_add_info_split($values)
    {
        $this->Fconnection();
        $today = date("Y-m-d");
        $sql_query = "insert into pr_info1(`pr_id`,`pr_type`,`pr_date`,`pr_by`,`pr_expected_date`,`pr_porpuse`,`expense_type`,`meterial_type`,`total_estimated_cost`,`delivery_instruction`,`remarks`,`status`,`date`,`user`,`license_id`,`co_id`,`pr_verify_by`,`pr_verify_date`,`pr_approve_by`,`pr_approval_date`,`uploaded_file`,`project_id`,`project_id_new`,`project_id_new_for`,`exp_description`)
SELECT  '$values[0]',`pr_type`,`pr_date`,`pr_by`,`pr_expected_date`,`pr_porpuse`,`expense_type`,`meterial_type`,`total_estimated_cost`,`delivery_instruction`,`remarks`,`status`,`date`,`user`,`license_id`,`co_id`,`pr_verify_by`,`pr_verify_date`,`pr_approve_by`,`pr_approval_date`,`uploaded_file`,`project_id`,`project_id_new`,`project_id_new_for`,`exp_description` FROM `pr_info1` WHERE pr_id = '$values[1]'";
//echo $sql_query;
        $pr2_add_sql = mysql_query("$sql_query");

        // $insert_pr2_sql= mysql_fetch_array($pr2_add_sql);
        //return $insert_pr2_sql;


        $info = mysql_insert_id();
        return $info;

    }

    public function pr2_add_info_split($values)
    {
        $this->Fconnection();
        $today = date("Y-m-d");
        $sql_query = "insert into pr_info3 (pr_id,tb_s1,tb_s2,tb_s3,tb_s4,tb_s5,tb_s6,tb_s7,tb_s8,tb_s9,tb_s10,tb_s11,tb_s12,comments,`status`,user)

SELECT '$values[0]', tb_s1,tb_s2,tb_s3,tb_s4,tb_s5,tb_s6,tb_s7,tb_s8,tb_s9,tb_s10,tb_s11,tb_s12,comments,`status`,user
FROM pr_info3
WHERE pr_id = '$values[1]'";
//echo $sql_query;
        $pr2_add_sql = mysql_query("$sql_query");

        // $insert_pr2_sql= mysql_fetch_array($pr2_add_sql);
        //return $insert_pr2_sql;


        $info = mysql_insert_id();
        return $info;

    }


    public function pr0_approval_info_split($values)
    {
        $this->Fconnection();
        $today = date("Y-m-d");
        $sql_query = "insert into scm_approval_tree (`pr_id`, `pr_date`, `pr_by`, `pr_approval_l1`, `pr_approval_l1_date`, `pr_approval_l2`, `pr_approval_l2_date`, `pr_approval_l3`, `pr_approval_l3_date`, `pq_id`, `pq_date`, `pq_by`, `pq_approval_l1`, `pq_approval_l1_date`, `pq_approval_l2`, `pq_approval_l2_date`, `pq_approval_l3`, `pq_approval_l3_date`, `po_id`, `po_date`, `po_by`, `po_approval_l1`, `po_approval_l1_date`, `po_approval_l2`, `po_approval_l2_date`, `po_approval_l3`, `po_approval_l3_date`, `po_approval_au_l1`, `po_approval_au_l1_date`, `po_approval_ac_l2`, `po_approval_ac_l2_date`, `po_approval_ac_l3`, `po_approval_ac_l3_date`, `flag`, `pr_31`, `pq_31`, `po_31`, `pq_forwarded_to`, `pq_forwarded_date`, `pq_forwarded2it`, `pq_forwarded2it_date`, `pq_it_st`, `pq_it_date`, `pr_forwarded_by`, `cancel_status`, `cancel_by`, `cancel_date`)

SELECT '$values[0]',`pr_date`, `pr_by`, `pr_approval_l1`, `pr_approval_l1_date`, `pr_approval_l2`, `pr_approval_l2_date`, `pr_approval_l3`, `pr_approval_l3_date`, `pq_id`, `pq_date`, `pq_by`, `pq_approval_l1`, `pq_approval_l1_date`, `pq_approval_l2`, `pq_approval_l2_date`, `pq_approval_l3`, `pq_approval_l3_date`, `po_id`, `po_date`, `po_by`, `po_approval_l1`, `po_approval_l1_date`, `po_approval_l2`, `po_approval_l2_date`, `po_approval_l3`, `po_approval_l3_date`, `po_approval_au_l1`, `po_approval_au_l1_date`, `po_approval_ac_l2`, `po_approval_ac_l2_date`, `po_approval_ac_l3`, `po_approval_ac_l3_date`, `flag`, `pr_31`, `pq_31`, `po_31`, `pq_forwarded_to`, `pq_forwarded_date`, `pq_forwarded2it`, `pq_forwarded2it_date`, `pq_it_st`, `pq_it_date`, `pr_forwarded_by`, `cancel_status`, `cancel_by`, `cancel_date`
FROM scm_approval_tree
WHERE pr_id = '$values[1]'";
//echo $sql_query;
        $pr2_add_sql = mysql_query("$sql_query");

        // $insert_pr2_sql= mysql_fetch_array($pr2_add_sql);
        //return $insert_pr2_sql;


        $info = mysql_insert_id();
        return $info;

    }


    public function pr_cashadd_info_($values)
    {
        $this->Fconnection();
        $today = date("Y-m-d");
        //echo 'aa'.$values[9];
        $sql = "insert into pr_cash_info (pr_cash_id,employee_id,justification,finantial_estimation,total_amount,user1,user2,user3,status,pr_id,date)
     values ('$values[0]','$values[1]','$values[2]','$values[3]','$values[4]','$values[5]','$values[6]','$values[7]','$values[8]','$valus[9]',now())";
        //echo $sql;
        $pr_cash_info_sql = mysql_query("$sql");
        $pr_cash_info_sql = mysql_fetch_array("$pr_cash_info_sql");
        return $pr_cash_info_sql;
    }

    public function pr_cash_info_emp($values)
    {
        $this->Fconnection();
        $today = date("Y-m-d");
        $sql = "SELECT pr_cash_id,employee_id,justification,finantial_estimation,total_amount,user1,user2,user3,`status` FROM pr_cash_info";
        //echo $sql;
        $pr_cash_info_emp_sql = mysql_query("$sql");
        $pr_cash_info_emp_fetch = mysql_fetch_array($pr_cash_info_emp_sql);
        return $pr_cash_info_emp_fetch;
    }

    ///////////////////////////////////////////////////////////////////////////////////////////
    public function pr_ifram_temp_item_info_($serv)
    {
        $this->Fconnection();
        //$insert_item="INSERT INTO tmp_item_info(item_name,description,ordered_quantity,unit,price_per_unit,total_value,pr_id,vat,date)VALUES('$serv[0]','$serv[1]','$serv[2]','$serv[3]','$serv[4]','$serv[5]','$serv[6]','$serv[7]',now())";

        $insert_item = "INSERT INTO tmp_item_info(item_name,description,ordered_quantity,unit,pr_id,vat,date,item_id)VALUES('$serv[0]','$serv[1]','$serv[2]','$serv[3]','$serv[4]','$serv[5]',now(),'$serv[0]')";
        //echo $insert_item;
        $result_insert = mysql_query($insert_item);
        $pr_cash_ifram_temp_item_info = mysql_fetch_array($result_insert);

    }

    public function tmp_item_info_calculation_($values)
    {
        $this->Fconnection();
        $sql = "select SUM(tmp_item_info.total_value),vat  from tmp_item_info where tmp_item_info.pr_id='$values' and tmp_item_info.pr_id!=''";
        //echo $sql;
        $sql_total = mysql_query("$sql");
        $total_count = mysql_fetch_row($sql_total);
        $vat = $total_count[1];
        $vat_cal = $vat / 100;
        //$total_count_vat=$total_count[0]*(0.15);
        $total_count_vat = $total_count[0] * $vat_cal;
        $total_count_vat_include = $total_count[0] + $total_count_vat;
        $count = array($total_count[0], $total_count_vat, $total_count_vat_include, $vat);
        return $count;
    }

    public function p0_item_genarel_view($serv)
    {
        $this->Fconnection();
        //$sql="SELECT pr_id,pr_type,pr_date,pr_porpuse,expense_type,meterial_type,total_estimated_cost,delivery_instruction,remarks,pr_by,license_id,co_id FROM pr_info1 where pr_tb_id<>0 $statement";
        $sql = "select (SELECT all_item_info.item_name FROM all_item_info WHERE all_item_info.item_tb_id = tmp_item_info.item_name) AS item_name,tmp_item_info.description,tmp_item_info.ordered_quantity,tmp_item_info.unit,tmp_item_info.price_per_unit,tmp_item_info.total_value,tmp_item_info.item_tb_id,tmp_item_info.pr_id FROM tmp_item_info where tmp_item_info.pr_id='$serv' and tmp_item_info.pr_id!=''";
        //echo $sql;
        $select_p0_view = mysql_query("$sql");
        while ($p0_view_list = mysql_fetch_array($select_p0_view)) {
            $p0_view[] = $p0_view_list;
        }
        return $p0_view;
    }
    ///////////////////////////////////////////////////////////////////////////////////////////
    //////////////////////////PO................//////////////////////////////////////////////
    public function po_auto_gen()
    {
        $this->Fconnection();
        $today = date("Y-m-d");
        //echo "select max(po_tb_id) from  po_info";
        $po_gen_max = mysql_query("select max(po_tb_id) from  po_info");
        $po_max_no = mysql_fetch_row($po_gen_max);
        //echo $po_max_no[0].'AA';
        $a = $po_max_no[0] + 1;
        //echo $a;
        $increment_value_po = 'FAHSC' . $today . 'PO' . $a;
        return $increment_value_po;
    }

    public function po0_add_info($values)
    {
        $this->Fconnection();
        $today = date("Y-m-d");
        $po0_sql = "insert into po_info (po_ref_no,vendor_tb_id,po_date,pr_id,delivery_terms,shipment_date,price,currency,fright_charge,warrenty,shipping_documents,
     blpcoo,payment_terms,payment_mode,delivery_date,delevery_place,delivery_status,po_approval_date,po_status,po_type,fh_contact_person_1,contact_number_1,fh_contact_person_2,contact_number_2,lc_number,pq_id)
    values ('$values[0]',0,'$values[2]','$values[3]','$values[4]','$values[5]','$values[6]','$values[7]','$values[8]','$values[9]','$values[10]',
    '$values[11]','$values[12]','$values[13]','$values[14]','$values[15]','$values[16]','$values[17]','$values[18]','$values[19]','$values[20]','$values[21]','$values[22]','$values[23]','$values[24]','$values[25]')";
        // echo $po0_sql;
        $po0_add_sql = mysql_query("$po0_sql");

        $info = mysql_insert_id();
        return $info;

    }


    public function po0_total_count($pr_id)
    {
        $this->Fconnection();
        $today = date("Y-m-d");
        $sql = "select SUM(tmp_item_info.total_value)  from tmp_item_info where pr_id='$pr_id'";
        //echo $sql;
        $sql_total = mysql_query("$sql");
        $total_count = mysql_fetch_row($sql_total);
        $total_count_vat = $total_count[0] * (0.15);
        $total_count_vat_includ = $total_count[0] + $total_count_vat;
        $pr_count_total = array($total_count[0], $total_count_vat, $total_count_vat_includ);
        return $pr_count_total;
    }

    public function delete_temp_item($idT, $idT2)
    {
        $this->Fconnection();
        //$today = date("Y-m-d");
        $sql = "delete from tmp_item_info where pr_id='$idT2' and item_tb_id='$idT'";
        //echo $sql;
        $sql_fetch = mysql_query("$sql");
        return $sql_fetch;
    }

    public function po_po_au_($val)
    {
        $this->Fconnection();
        //$today = date("Y-m-d");
        $sql = "select * from po_info where pr_id='$val'";
        //echo $sql;
        $sql_fetch = mysql_query("$sql");
        $po0_sql = mysql_fetch_array($sql_fetch);
        return $po0_sql;
    }

    ////////////////////////////////////PQ/////////////////////////////////////////////////////
    public function pq_auto_gen_()
    {
        $this->Fconnection();
        $today = date("Y-m-d");
        //$max="select max(id) from  client_info
        $pq_gen_max = mysql_query("select max(pq_tb_id) from  pq_info1");
        $pq_max_no = mysql_fetch_row($pq_gen_max);
        $a = $pq_max_no[0] + 1;
        $increment_value_pq = 'FAHSC' . $today . 'PQ' . $a;
        return $increment_value_pq;
    }

    public function pq0_add_info($values)
    {
        $this->Fconnection();
        $today = date("Y-m-d");
        $pq0_sql = "insert into pq_info1 (pq_id,pq_type,pq_date,pq_by,pq_porpuse,expense_type,meterial_type,total_estimated_cost,delivery_instruction,remarks,license_id,co_id,pr_id,vendor_tb_id,
        pq_attention,pq_subject,delivery,payment,mod_pay_type,inspection,packing,validity,warenty,installetion,other,days_workingdays,days_working_days_total,pq_number,upload)
        values ('$values[0]','$values[1]','$values[2]','$values[3]','$values[4]','$values[5]','$values[6]','$values[7]','$values[8]','$values[9]','$values[10]','$values[11]','$values[12]','$values[13]','$values[14]','$values[15]','$values[16]','$values[17]','$values[18]','$values[19]','$values[20]','$values[21]','$values[22]','$values[23]','$values[24]','$values[25]','$values[26]','$values[27]','$values[28]')";
//echo $pq0_sql;
        $pq0_add_sql = mysql_query("$pq0_sql");

        $info = mysql_insert_id();
        return $info;
    }

    public function pq_ifram_temp_item_info_($serv)
    {
        $this->Fconnection();
        $insert_item = "INSERT INTO pq_item_info(item_name,description,ordered_quantity,unit,price_per_unit,total_value,pr_id,pq_id,pq_number,vat,item_id)
                          VALUES('$serv[0]','$serv[1]','$serv[2]','$serv[3]','$serv[4]','$serv[5]','$serv[6]','$serv[7]','$serv[8]','$serv[9]','$serv[10]')";
        // echo $insert_item;
        $result_insert = mysql_query($insert_item);
        $pr_cash_ifram_temp_item_info = mysql_fetch_array($result_insert);

    }

    public function pq0_total_count($pr_id)
    {
        $this->Fconnection();
        $today = date("Y-m-d");
        $sql = "select SUM(tmp_item_info.total_value)  from tmp_item_info where pr_id='$pr_id'";
        //echo $sql;
        $sql_total = mysql_query("$sql");
        $total_count = mysql_fetch_row($sql_total);
        $total_count_vat = $total_count[0] * (0.15);
        $total_count_vat_includ = $total_count[0] + $total_count_vat;
        $pr_count_total = array($total_count[0], $total_count_vat, $total_count_vat_includ);
        return $pr_count_total;
    }

    public function pq_p0_gridview_($pr_id)
    {
        $this->Fconnection();
        $sql = "Select * from pq_info1 where pr_id=$pr_id order by pq_tb_id desc";
        //echo $sql;
        $select_pq_p0_gridview = mysql_query("$sql");
        while ($pq_p0_gridview_list = mysql_fetch_array($select_pq_p0_gridview)) {
            $pq_p0_gridview[] = $pq_p0_gridview_list;
        }
        return $pq_p0_gridview;
    }

    public function pq_qcs($pr_id)
    {
        $this->Fconnection();
        $sql = "Select * from pq_info1 where pr_id=$pr_id group by pq_id order by pq_tb_id desc";
        //echo $sql;
        $select_pq_view = mysql_query("$sql");
        while ($pq_list = mysql_fetch_array($select_pq_view)) {
            $pq_view[] = $pq_list;
        }
        return $pq_view;
    }

    public function pq_qcs_q1q2q3($pr_id, $pq_number)
    {
        $this->Fconnection();
        $sql = "Select * from pq_info1 where pr_id='$pr_id' and pq_number='$pq_number'  order by pq_tb_id desc";
        //echo $sql;
        $select_pq_view = mysql_query("$sql");
        $pq_list = mysql_fetch_array($select_pq_view);
        return $pq_list;
    }

//count pq based on pq_by
    public function pq_qcs_q1q2q3_count($pq_by)
    {
        $this->Fconnection();
        $sql = "Select * from pq_info1 where pq_by='$pq_by' ";
        //   echo $sql;
        $select_pq_view = mysql_query("$sql");

        return $select_pq_view;
    }


    public function pq_unique($pq_id)
    {
        $this->Fconnection();
        $sql = "Select * from pq_info1 where pq_id='$pq_id'";
        //echo $sql;
        $select_pq_view = mysql_query("$sql");
        $pq_list = mysql_fetch_array($select_pq_view);
        return $pq_list;
    }

    ///////////////////////////////////ApprovalPrPqPo//////////////////////////////////////////////////
    public function pr0_approval_info($values)
    {
        $this->Fconnection();
        $today = date("Y-m-d");
        $pr0_sql = "insert into $values[3] (pr_id,pr_date,pr_by) values('$values[0]','$values[1]','$values[2]')";
        //echo $pr0_sql;
        $select_pq_view = mysql_query($pr0_sql);
        // echo $select_pq_view;


        $info = mysql_insert_id();
        return $info;


        // $pr0_add_sql=mysql_query("$pr0_sql");

        // $insert_pr0_sql= mysql_fetch_array("$pr0_add_sql");
        // return $insert_pr0_sql;
    }

    public function pq0_approval_info($values)
    {
        $this->Fconnection();
        $today = date("Y-m-d");
        $pq0_sql = "update scm_approval_tree set pq_id=$values[0],date='$values[1]' where pr_id='$values[3]'";
        //echo $pr0_sql;
        $pq0_add_sql = mysql_query("$pq0_sql");

        $insert_pq0_sql = mysql_fetch_array("$pq0_add_sql");
        return $insert_pq0_sql;
    }

    public function po0_approval_info($values)
    {
        $this->Fconnection();
        $today = date("Y-m-d");
        $po0_sql = "update scm_approval_tree set po_id='$values[0]',po_date='$values[1]',po_by='$values[2]' where pr_id='$values[3]'";
        //echo $po0_sql;
        $po0_add_sql = mysql_query("$po0_sql");

        $insert_po0_sql = mysql_fetch_array("$po0_add_sql");
        return $insert_po0_sql;
    }

    public function po0_approval_info_au($values)
    {
        $this->Fconnection();
        $today = date("Y-m-d");
        //$po0_sql="update scm_approval_tree set po_id='$values[0]',po_date='$values[1]',po_by='$values[2]' where pr_id='$values[3]'";
        $po0_sql = "update scm_approval_tree set po_approval_au_l1='$values[0]',po_approval_au_l1_date='$values[1]' where pr_id='$values[2]'";
        //echo $po0_sql;
        $po0_add_sql = mysql_query("$po0_sql");

        $insert_po0_sql = mysql_fetch_array("$po0_add_sql");
        return $insert_po0_sql;
    }

    public function po0_approval_info_ac($values)
    {
        $this->Fconnection();
        $today = date("Y-m-d");
        //$po0_sql="update scm_approval_tree set po_id='$values[0]',po_date='$values[1]',po_by='$values[2]' where pr_id='$values[3]'";
        $po0_sql = "update scm_approval_tree set po_approval_ac_l3='$values[0]',po_approval_ac_l3_date='$values[1]' where pr_id='$values[2]'";
        // echo $po0_sql;
        $po0_add_sql = mysql_query("$po0_sql");

        $insert_po0_sql = mysql_fetch_array("$po0_add_sql");
        return $insert_po0_sql;
    }


    public function scm_approval_tree($statement, $start_from, $num_rec_per_page)
    {
        $this->Fconnection();

        //   $sql="select * from scm_approval_tree where id<>0 $statement order by id desc LIMIT $start_from, $num_rec_per_page ";

        $sql = "select * from scm_approval_tree where id<>0 $statement  LIMIT $start_from, $num_rec_per_page";
//echo $sql;
        $scm_approval_tree_sql = mysql_query("$sql");
        return $scm_approval_tree_sql;
    }


    public function scm_approval_tree_test($statement, $start_from, $num_rec_per_page)
    {
        $this->Fconnection();
        $sql = "SELECT pr_info1.pr_id,pr_info1.pr_type,pr_info1.pr_date,pr_info1.pr_porpuse,pr_info1.expense_type,pr_info1.meterial_type,pr_info1.total_estimated_cost,pr_info1.delivery_instruction,pr_info1.remarks,pr_info1.pr_by,pr_info1.license_id,pr_info1.co_id FROM pr_info1,scm_approval_tree where pr_info1.pr_id=scm_approval_tree.pr_id and scm_approval_tree.pr_approval_l2!='' and pr_info1.pr_tb_id<>0 $statement order by pr_info1.pr_tb_id desc LIMIT $start_from, $num_rec_per_page";
//echo $sql;
        $scm_approval_tree_sql = mysql_query("$sql");


        return $scm_approval_tree_sql;


        /*
     $scm_approval_tree_sql=mysql_query("$sql");
     while($scm_approval_tree=mysql_fetch_array($scm_approval_tree_sql))
     {
       $list_scm_approval_tree[]=$scm_approval_tree;
     }
    return $list_scm_approval_tree;
*/

    }


    public function scm_approval_tree_count($statement)
    {
        $this->Fconnection();

//           $sql="select * from scm_approval_tree where id<>0 $statement order by id desc LIMIT $start_from, $num_rec_per_page ";

        $sql = "
select
    * 
from
    scm_approval_tree 
where
    id<>0 $statement 
order by
    id desc
        ";
        $sql1 = "
SELECT scm_approval_tree.*
FROM scmv3.pr_info1,
     scmv3.scm_approval_tree
WHERE pr_info1.pr_id = scm_approval_tree.pr_id
  AND pr_info1.pr_date < '2016-01-01 00:00:00'
  AND pr_approval_l1 IS NOT NULL
  AND pr_approval_l2 IS NOT NULL
  AND pr_approval_l3 IS NOT NULL
  AND scm_approval_tree.cancel_status != 1
  AND scm_approval_tree.pq_id IS NULL
order by id desc
        ";
//echo $sql;
        $scm_approval_tree_sql = mysql_query("$sql");


        return $scm_approval_tree_sql;


        /*
     $scm_approval_tree_sql=mysql_query("$sql");
     while($scm_approval_tree=mysql_fetch_array($scm_approval_tree_sql))
     {
       $list_scm_approval_tree[]=$scm_approval_tree;
     }
    return $list_scm_approval_tree;scm_approval_tree_count_dashboard
*/

    }


    public function scm_approval_tree_count_dashboard($statement)
    {
        $this->Fconnection();
        $sql = "
SELECT 
    pr_info1.pr_id,
    pr_info1.pr_type,
    pr_info1.pr_date,
    pr_info1.pr_porpuse,
    pr_info1.expense_type,
    pr_info1.meterial_type,
    pr_info1.total_estimated_cost,
    pr_info1.delivery_instruction,
    pr_info1.remarks,
    pr_info1.pr_by,
    pr_info1.license_id,
    pr_info1.co_id,
    `pr_info1`.pr_verify_by,
    `pr_info1`.pr_verify_date,
    `pr_info1`.pr_approve_by,
    `pr_info1`.pr_approval_date,
    `scm_approval_tree`.cancel_by,
    `scm_approval_tree`.id
    
FROM
    `pr_info1`,
    scm_approval_tree
WHERE
    pr_info1.pr_id = scm_approval_tree.pr_id
        AND scm_approval_tree.pr_id != ''
        AND scm_approval_tree.cancel_status = 1
        $statement
        ";
        $scm_approval_tree_sql = mysql_query("$sql");
        return $scm_approval_tree_sql;


        /*
     $scm_approval_tree_sql=mysql_query("$sql");
     while($scm_approval_tree=mysql_fetch_array($scm_approval_tree_sql))
     {
       $list_scm_approval_tree[]=$scm_approval_tree;
     }
    return $list_scm_approval_tree;scm_approval_tree_count_dashboard
*/

    }

    public function scm_approval_tree_count_manual_po($statement)
    {
        $this->Fconnection();

//           $sql="select * from scm_approval_tree where id<>0 $statement order by id desc LIMIT $start_from, $num_rec_per_page ";
//
//        $sql="select * from scm_approval_tree where id<>0 $statement order by id desc";
        $sql1 = "
SELECT
    scm_approval_tree.* 
FROM
    scmv3.pr_info1,
    scmv3.scm_approval_tree 
WHERE
    pr_info1.pr_id = scm_approval_tree.pr_id   
    AND pr_info1.pr_date < '2016-01-01 00:00:00'   
    AND pr_approval_l1 IS NOT NULL   
    AND pr_approval_l2 IS NOT NULL   
    AND pr_approval_l3 IS NOT NULL   
    AND scm_approval_tree.cancel_status != 1   
    AND scm_approval_tree.pq_id IS NULL 
order by
    id desc
        ";
//echo $sql;
        $scm_approval_tree_sql = mysql_query("$sql1");


        return $scm_approval_tree_sql;


        /*
     $scm_approval_tree_sql=mysql_query("$sql");
     while($scm_approval_tree=mysql_fetch_array($scm_approval_tree_sql))
     {
       $list_scm_approval_tree[]=$scm_approval_tree;
     }
    return $list_scm_approval_tree;
*/

    }

//pagination

    public function scm_approval_tree_pagination($statement, $start_from, $num_rec_per_page)
    {
        $this->Fconnection();

        $sql = "select * from scm_approval_tree where id<>0 $statement order by id desc LIMIT $start_from, $num_rec_per_page";
        $scm_approval_tree_sql = mysql_query("$sql");

        return $scm_approval_tree_sql;
    }

    //


    public function scm_approval_tree_unique($val)
    {
        $this->Fconnection();

        $sql = "select * from scm_approval_tree where pr_id='$val'";
        // echo "$sql";
        $scm_approval_tree_sql = mysql_query("$sql");
        $scm_approval_tree = mysql_fetch_array($scm_approval_tree_sql);
        return $scm_approval_tree;
    }

    public function scm_approval_tree_unique_app($val, $val1)
    {
        $this->Fconnection();
        //echo $val1.'eee';
        $sql = "select * from scm_approval_tree where pr_id='$val' and pq_forwarded_to='$val1'";
        //echo "$sql";
        $scm_approval_tree_sql = mysql_query("$sql");
        $scm_approval_tree = mysql_fetch_array($scm_approval_tree_sql);
        return $scm_approval_tree;
    }

    public function scm_approval_tree_unique_it($val, $val1)
    {
        $this->Fconnection();
        //echo $val1.'eee';
        $sql = "select * from scm_approval_tree where pr_id='$val' and pq_forwarded2it='$val1'";
        //echo "$sql";
        $scm_approval_tree_sql = mysql_query("$sql");
        $scm_approval_tree = mysql_fetch_array($scm_approval_tree_sql);
        return $scm_approval_tree;
    }

    public function pr0_approval_line_man($val)
    {
        $this->Fconnection();

        $sql = "
update
    scm_approval_tree 
set
    pr_approval_l1='$val[2]',
    pr_approval_l1_date='$val[1]',
    pr_approval_l2='$val[4]',
    pr_approval_l2_date='$val[3]'   
where
    pr_id='$val[0]'
        ";
        //echo "$sql";
        $pr0_approval_line_man = mysql_query("$sql");
        $scm_approval_line_man = mysql_fetch_array($pr0_approval_line_man);

        if ($pr0_approval_line_man) // will return true if succefull else it will return false
        {
            return 1;
        } else {

            return 0;
        }


    }


    public function pr0_approval_line_man_hod($val)
    {
        $this->Fconnection();

        $sql = "update scm_approval_tree set pr_approval_l2='$val[2]',pr_approval_l2_date='$val[1]' where pr_id='$val[0]'";
        // echo "$sql";
        $pr0_line_man = mysql_query("$sql");
        $scm_line_man = mysql_fetch_array($pr0_line_man);
        return $scm_line_man;
    }


    public function pr0_line_man($val)
    {
        $this->Fconnection();

        $sql = "update pr_info3 set comments2='$val[5]' where pr_id='$val[0]'";
        // echo "$sql";
        $pr0_line_man = mysql_query("$sql");
        $scm_line_man = mysql_fetch_array($pr0_line_man);
        return $scm_line_man;
    }

    public function pr0_approval_hod($val)
    {
        $this->Fconnection();

        $sql = "update scm_approval_tree set pr_approval_l2='$val[4]',pr_approval_l2_date='$val[3]'   where pr_id='$val[0]'";
        // echo "$sql";
        $pr0_approval_line_man = mysql_query("$sql");
        $scm_approval_line_man = mysql_fetch_array($pr0_approval_line_man);
        return $scm_approval_line_man;
    }

    public function pr0_forword_scm($val)
    {
        $this->Fconnection();

        $sql = "update scm_approval_tree set pr_approval_l3='$val[2]',pr_approval_l3_date='$val[1]',pr_forwarded_by='$val[3]'  where pr_id='$val[0]'";
        // echo "$sql";
        $pr0_approval_line_man = mysql_query("$sql");
        $scm_approval_line_man = mysql_fetch_array($pr0_approval_line_man);
        return $pr0_approval_line_man;
    }

    ////////////////////////////////cancel PR////////////////////////////////////////////////////
    public function pr0_cancel_scm($val)
    {
        $this->Fconnection();

        $sql = "update scm_approval_tree set cancel_status=1,cancel_by='$val[2]',cancel_date='$val[1]'  where pr_id='$val[0]'";
        //echo "$sql";
        $pr0_cancel = mysql_query("$sql");
        $pr0_cancel_man = mysql_fetch_array($pr0_cancel);
        return $pr0_cancel_man;
    }

    ////////////////////////////////ACC////////////////////////////////////////////////////
    public function input_payment_info($values)
    {
        $this->Fconnection();
        $sql = "insert into popqpr_acc_info (invoice_no,money_receipt_no,client_id,date_of_collection,collection_amount,payment_type,mod_of_payment,receivable_amount,input_by,date,check_no,check_date,check_type,bank_name)
        values ('$values[0]','$values[1]','$values[2]','$values[3]','$values[4]','$values[5]','$values[6]','$values[7]','$values[8]','$values[9]','$values[10]','$values[11]','$values[12]','$values[13]')";
        //echo $sql;
        $insert_daily_collection_sql = mysql_query($sql);
        return $insert_daily_collection_sql;
    }

    ///////////////////////////////////////////////////////////////////////////////////////////
    public function SupervisorStatus11($emID)
    {
        $this->Fconnection();

        $selectSupervisorStatusSql = mysql_query("
select
    * 
from
    tbl_tier 
where
    tr1='$emID' 
    or tr2='$emID' 
    or tr3='$emID' 
    or tr4='$emID' 
    or tr5='$emID' 
    or employee_id='$emID'
");
        while ($allSupervisorData = mysql_fetch_array($selectSupervisorStatusSql)) {
            $superData[] = $allSupervisorData;
        }
        return $superData;
    }

    ///////////////////////////////////
    public function UserAllInfo_uniq($employee_id)
    {
        $this->Fconnection();
        //echo "select tpi.employee_id,tpi.employee_name,tpi.official_cell_no,toi.designation,toi.department_name,tpi.official_email from tbl_personal_info as tpi,tbl_office_info as toi where tpi.employee_id='$employee_id' and tpi.id=toi.emp_id";
        $selectUserAllInfoSql = mysql_query("
select
    tpi.employee_id,
    tpi.employee_name,
    tpi.official_cell_no,
    toi.designation,
    toi.department_name,
    tpi.official_email 
from
    tbl_personal_info as tpi,
    tbl_office_info as toi 
where
    tpi.employee_id='$employee_id' 
    and tpi.id=toi.emp_id
    ");
        //echo "select tpi.employee_id,tpi.employee_name,tpi.official_cell_no,toi.designation,toi.department_name,tpi.official_email from tbl_personal_info as tpi,tbl_office_info as toi where tpi.employee_id='$employee_id' and tpi.id=toi.emp_id";
        // echo "select tpi.employee_id,tpi.employee_name,tpi.official_cell_no,toi.designation,toi.department_name,tpi.official_email from tbl_personal_info as tpi,tbl_office_info as toi where tpi.employee_id='$employee_id' and tpi.id=toi.emp_id";
        $selectDataBySql = mysql_fetch_array($selectUserAllInfoSql);


        return $selectDataBySql;
    }

    ///////////////////////////////////

    public function tier_name($val)
    {
        $this->Fconnection();
        $sql = "select * from tbl_tier where employee_id='$val'";
        //echo $sql;
        $select_employee_sql = mysql_query("$sql");
        $employee_data_set = mysql_fetch_array($select_employee_sql);
        return $employee_data_set;
    }

    /*
*
* Function: tier1_name
  select one user's downstream data.

* Parameters:
  $val - user's id.

*   Returns:
  one user's downstream data.find_gr_not_assigned_asset

 */
    public function tier1_name($val1)
    {
        $this->Fconnection();
        $sql = "select * from tbl_tier where tr1='$val1' and attendance_status=1";
        // echo $sql;
        $select_employee_sql = mysql_query("$sql");
        //  $employee_data_set=mysql_fetch_array($select_employee_sql);
        return $select_employee_sql;
    }

    public function find_gr_not_assigned_asset($val1)
    {
        $this->Fconnection();
        $sql = "select * from availability_start_end where item_id=$val1 and status=0";
//        $sql="select * from all_item_asset_code where item_id=$val1 and status=0";
        // echo $sql;
        $select_employee_sql = mysql_query("$sql");
        //  $employee_data_set=mysql_fetch_array($select_employee_sql);
        return $select_employee_sql;
    }

    public function find_gr_not_assigned_asset_total($val1)
    {
        $this->Fconnection();
//        $sql="select * from all_item_asset_code where item_id=$val1 and status=0";
        // echo $sql;
        $sql = "select * from availability_start_end where item_id=$val1 and status=0 ";
        $select_employee_sql = mysql_query("$sql");
        //  $employee_data_set=mysql_fetch_array($select_employee_sql);
        return $select_employee_sql;
    }

    public function find_gr_not_unassigned_asset($val1, $val2)
    {
        $this->Fconnection();
        $sql = "select * from current_item_info_fainal where item_id=$val1 and mi_id like '$val2'order by id desc";
        // echo $sql;
        $select_employee_sql = mysql_query("$sql");
        //  $employee_data_set=mysql_fetch_array($select_employee_sql);
        return $select_employee_sql;
    }

    public function find_asset_type($val1, $val2)
    {
        $this->Fconnection();
        $sql = "select * from all_item_info where item_id=$val1";

        $select_item_sql = mysql_query("$sql");
        while ($customer_res = mysql_fetch_array($select_item_sql)) {
            $cus_data[] = $customer_res;
        }

        return $cus_data;
    }

    //////////////////Discontinue Info////////////////////////
    public function client_name($val)
    {
        $this->Fconnection();
        //echo "select * from tbl_client_info where client_id='$val'";
        $customer_show = mysql_query("select * from tbl_client_info where client_id='$val'");
        $result_set = mysql_fetch_array($customer_show);
        return $result_set;
    }

    public function customer_data_all()
    {
        $this->Fconnection();

        $select_customer_data_sql = mysql_query("select * from tbl_client_info order by client_name asc");
        while ($customer_res = mysql_fetch_array($select_customer_data_sql)) {
            $cus_data[] = $customer_res;
        }
        return $cus_data;
    }

    public function change_data_count_total($statement)
    {
        $this->Fconnection();
        $sql_cdct = "SELECT
  `tbl_sentral_update_billing_total`.id,
  `tbl_sentral_update_billing_total`.client_id,
  `tbl_sentral_update_billing_total`.existing_capacity,
  `tbl_sentral_update_billing_total`.existing_capacity_type,
  `tbl_sentral_update_billing_total`.request_capacity,
  `tbl_sentral_update_billing_total`.request_capacity_type,
  `tbl_sentral_update_billing_total`.new_capacity,
  `tbl_sentral_update_billing_total`.new_capacity_type,
  `tbl_sentral_update_billing_total`.effect_date,
  `tbl_sentral_update_billing_total`.active_date,
  `tbl_sentral_update_billing_total`.change_date,
  `tbl_sentral_update_billing_total`.scr_id,
  `tbl_sentral_update_billing_total`.`status`,
  `tbl_sentral_update_billing_total`.check_id,
  `tbl_sentral_update_billing_total`.track_id,
  `tbl_sentral_update_billing_total`.`date`,
  `tbl_sentral_update_billing_total`.shifted_scr_id,
  `tbl_sentral_update_billing_total`.product_type_id,
  `tbl_sentral_update_billing_total`.pr_sub_type_id
FROM
  `tbl_sentral_update_billing_total`, tbl_client_info
  where `tbl_sentral_update_billing_total`.`client_id`=`tbl_client_info`.`client_id`
  and `tbl_sentral_update_billing_total`.`status`='Discontinue' and `tbl_sentral_update_billing_total`.`status_sn`!='Ignore'
  and `tbl_sentral_update_billing_total`.`status_sn`!='Rejected' and `tbl_client_info`.`client_id`<>0 $statement
  order by `tbl_sentral_update_billing_total`.effect_date desc";

        //echo $sql_cdct;
        $select_change_data_sql = mysql_query("$sql_cdct");
        while ($change_data_set = mysql_fetch_array($select_change_data_sql)) {
            $chData[] = $change_data_set;
        }
        return $chData;
    }
    //////////////////////////////////////////
    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    public function mr_auto_gen_($mr_sts)
    {
        $this->Fconnection();
        $today = date("Y-m-d");
        $val = $_SESSION['employee_id'];
        //$max="select max(id) from  client_info
        if ($mr_sts == 1) {
            $mr_gen_max = mysql_query("select * from  mr_info1 where flag = $mr_sts group by mr_id");
            //$mr_max_no=mysql_fetch_row($mr_gen_max);
            $mr_max_no = mysql_num_rows($mr_gen_max);
            $a = $mr_max_no + 1;
            $increment_value_mr = 'FAHINFO3' . $val . $today . 'MR' . $a;
        } else {
            $mr_gen_max1 = mysql_query("select max(mr_tb_id) from  mr_info1 where flag = 0");
            $mr_max_no1 = mysql_fetch_row($mr_gen_max1);
            $mr_gen_max = mysql_query("select mr_id from  mr_info1 where mr_tb_id = $mr_max_no1[0]");
            $mr_max_no = mysql_fetch_row($mr_gen_max);
            $varii = explode('MR', $mr_max_no[0]);
            $a = $varii[1] + 1;
            $increment_value_mr = 'FAHSC' . $val . $today . 'MR' . $a;
        }
        return $increment_value_mr;

    }


    public function mi_auto_gen_()
    {
        $this->Fconnection();
        $today = date("Y-m-d");
        $val = $_SESSION['employee_id'];
        $sql = "select max(id) from  current_item_info_fainal";
        //echo $sql;
        $mi_gen_max = mysql_query($sql);
        $mi_max_no = mysql_fetch_row($mi_gen_max);
        $a = $mi_max_no[0] + 1;
        $increment_value_mi = 'FAHINV' . $today . 'MI' . $a;
        //echo $increment_value_mi;
        return $increment_value_mi;

    }

    public function mi_auto_gen_infosarkar()
    {
        $this->Fconnection();
        $today = date("Y-m-d");
        $val = $_SESSION['employee_id'];
        $sql = "select * from  current_item_info_fainal_infosarkar where mi_id !='' GROUP BY mi_id ";
        //echo $sql;
        $mi_gen_max = mysql_query($sql);
        $mr_max_no = mysql_num_rows($mi_gen_max);
        $a = $mr_max_no + 1;
        $increment_value_mi = 'FAHINFO3' . $today . 'MI' . $a;
        // echo $increment_value_mi;
        return $increment_value_mi;

    }

    public function rq_auto_gen_()
    {

        /*

 $this->Fconnection();
     $today = date("Y-m-d");
     $val=$_SESSION['employee_id'];
    $sql="SELECT * FROM  current_item_info_fainal_local_co_infosarkar   GROUP BY rq_id";
    //echo $sql;
     $grn_gen_max=mysql_query($sql);
     $max=mysql_num_rows($grn_gen_max);
    // $grn_max_no=mysql_fetch_row($grn_gen_max);
     $a=$max + 1;
     $increment_value_grn='FAHINFO3'.$val.$today.'RQ'.$a;
     return $increment_value_grn;

*/

        $this->Fconnection();
        $today = date("Y-m-d");
        $val = $_SESSION['employee_id'];
        $sql = "SELECT MAX(rq_id) FROM current_item_info_fainal_local_co_infosarkar ";

        $grn_gen_max = mysql_query($sql);

        $grn_max_no = mysql_fetch_row($grn_gen_max);
        $varii = explode('RQ', $grn_max_no[0]);
        $last = end($varii);
        $a = $last + 1;
        $increment_value_mi = 'FAHINV' . $today . 'RQ' . $a;

        return $increment_value_mi;
    }


    public function rq_auto_gen_general()
    {
        /*$this->Fconnection();
     $today = date("Y-m-d");
     //$val=$_SESSION['employee_id'];
    $sql="select * FROM    current_item_info_fainal_local_co GROUP BY rq_id";
    //echo $sql;
     $mi_gen_max=mysql_query($sql);
     $max=mysql_num_rows($mi_gen_max);
     $a=$max + 1;
     $increment_value_mi='FAHINV'.$today.'RQ'.$a;
     //echo $increment_value_mi;
     return $increment_value_mi;*/


        $this->Fconnection();
        $today = date("Y-m-d");
        $val = $_SESSION['employee_id'];
        $sql = "SELECT MAX(rq_id) FROM current_item_info_fainal_local_co ";

        $grn_gen_max = mysql_query($sql);

        $grn_max_no = mysql_fetch_row($grn_gen_max);
        $varii = explode('RQ', $grn_max_no[0]);
        $last = end($varii);
        $a = $last + 1;
        $increment_value_mi = 'FAHINV' . $today . 'RQ' . $a;

        return $increment_value_mi;


    }


    public function mr_po_check($po_id)
    {
        $this->Fconnection();
        //$pr_p0_details_sql=mysql_query("SELECT pr_id,pr_type,pr_date,pr_porpuse,expense_type,meterial_type,total_estimated_cost,delivery_instruction,remarks,pr_by,license_id,co_id FROM pr_info1 where pr_id='$pr_id'");
        $sql = "SELECT * FROM scm_approval_tree_inventory where po_id='$po_id' and po_id!=''";
        // echo $sql;
        $mr_p0_details_sql = mysql_query($sql);
        //$mr_p0_info=mysql_fetch_array($mr_p0_details_sql);
        while ($mr_p0_details_sql_list = mysql_fetch_array($mr_p0_details_sql)) {
            $mr_po_gridview[] = $mr_p0_details_sql_list;
        }
        return $mr_po_gridview;

    }

    public function mr0_total_count($pr_id)
    {
        $this->Fconnection();
        $today = date("Y-m-d");
        $sql = "select SUM(tmp_item_info_mr.total_value)  from tmp_item_info_mr where mr_id='$mr_id'";
        //echo $sql;
        $sql_total = mysql_query("$sql");
        $total_count = mysql_fetch_row($sql_total);
        $total_count_vat = $total_count[0] * (0.15);
        $total_count_vat_includ = $total_count[0] + $total_count_vat;
        $mr_count_total = array($total_count[0], $total_count_vat, $total_count_vat_includ);
        return $mr_count_total;
    }

    public function mr0_count($mr_id)
    {
        $this->Fconnection();
        $today = date("Y-m-d");
        $sql = "select sum(tmp_item_info_mr.id)  from tmp_item_info_mr where mr_id='$mr_id'";
        //echo $sql;
        $sql_total = mysql_query("$sql");
        $total_count = mysql_fetch_row($sql_total);
        return $total_count;
    }

    public function mr0_add_info($values)
    {
        $this->Fconnection();
        $today = date("Y-m-d H:i:s");
        $mr0_sql = "insert into $values[22] (mr_id,mr_type,mr_date,mr_by,mr_porpuse,expense_type,meterial_type,total_estimated_cost,delivery_instruction,remarks,license_id,co_id,project_id,project_id_new,project_id_new_for,exp_description,expected_date,employee_to,district,upazilla_id, union_id,local_co_id,flag,mi_page_status)
values ('$values[0]','$values[1]','$today','$values[3]','$values[4]','$values[5]','$values[6]','$values[7]','$values[8]','$values[9]','$values[10]','$values[11]','$values[12]','$values[13]','$values[14]','$values[15]','$values[16]','$values[17]','$values[18]','$values[19]','$values[20]','$values[21]',$values[23],$values[24])";
//echo $mr0_sql;
        $mr0_add_sql = mysql_query("$mr0_sql");

        $info = mysql_insert_id();
        return $info;

        // $insert_mr0_sql= mysql_fetch_array("$mr0_add_sql");
        //return $insert_mr0_sql;
    }

    public function get_personal_temp_MR($var)
    {
        $this->Fconnection();

//$sSqlWrk = "SELECT * FROM `scm_approval_tree_inventory_temp` WHERE mr_by = '$var'


        $sql = mysql_query("SELECT scm_approval_tree_inventory_temp.mr_id,mr_info1_temp.project_id,scm_approval_tree_inventory_temp.mr_by FROM `scm_approval_tree_inventory_temp`,mr_info1_temp WHERE scm_approval_tree_inventory_temp.mr_id=mr_info1_temp.mr_id AND scm_approval_tree_inventory_temp.mr_by ='$var'");

        return $sql;
    }


    public function mr0_approval_info($values)
    {
        $this->Fconnection();
        $today = date("Y-m-d");
        $mr0_sql = "insert into $values[3] (mr_id,mr_date,mr_by) values('$values[0]','$today','$values[2]')";
        //echo $pr0_sql;
        $mr0_add_sql = mysql_query("$mr0_sql");

        $insert_mr0_sql = mysql_fetch_array("$mr0_add_sql");
        return $insert_mr0_sql;
    }

    public function mr0_approval_info_update($values)
    {
        $this->Fconnection();
        $today = date("Y-m-d");
        $pr0_edit_info_sql1 = "UPDATE $values[3] SET `mr_date`=$values[2] WHERE mr_id ='$values[0]' and mr_id !=''";

        //echo $pr0_edit_info_sql1;
        $pr0_edit_info = mysql_query("$pr0_edit_info_sql1");

        $pr0_edit_info_sql = mysql_fetch_array("$pr0_edit_info");
        return $pr0_edit_info_sql;
    }

    public function mr_temp_item_info_temp_edit($values, $table_tmp_item_info_temp)
    {
        $this->Fconnection();
        $today = date("Y-m-d");
        $sql = mysql_query("SELECT *  FROM  all_item_info WHERE item_id = '$values[0]'");
        // echo "SELECT *  FROM  all_item_info WHERE item_id = '$value_item_name[$i]'";
        $unit_val = mysql_fetch_row($sql);


        $pr_temp_item_info_edit = "update $table_tmp_item_info_temp set item_name='$values[0]',description='$values[1]',ordered_quantity='$values[2]',unit='$unit_val[9]',vat='$values[5]',date='$today',item_id='$values[0]', sl=$unit_val[30] where mr_id='$values[4]' and item_tb_id=$values[6]";
        //echo $pr_temp_item_info_edit;
        $pr_temp_item_info_edit_q = mysql_query($pr_temp_item_info_edit);

        // $pr_temp_item_info_edit_sql= mysql_fetch_array("$pr_temp_item_info_edit_q");
        return $pr_temp_item_info_edit_q;
    }


    public function delete_temp_item_mr($idT, $idT2)
    {
        $this->Fconnection();
        //$today = date("Y-m-d");
        $sql = "delete from tmp_item_info_mr where mr_id='$idT2' and item_tb_id='$idT'";
        //echo $sql;
        $sql_fetch = mysql_query("$sql");
        return $sql_fetch;
    }

    public function mr_p0_gridview($statement)
    {
        $this->Fconnection();
        $sql = "SELECT mr_id,mr_type,mr_date,mr_porpuse,expense_type,meterial_type,total_estimated_cost,delivery_instruction,remarks,mr_by,license_id,co_id FROM mr_info1 where mr_tb_id<>0 $statement order by mr_tb_id desc";
        //echo $sql;
        $select_mr_p0_gridview = mysql_query("$sql");
        while ($mr_p0_gridview_list = mysql_fetch_array($select_mr_p0_gridview)) {
            $mr_p0_gridview[] = $mr_p0_gridview_list;
        }
        return $mr_p0_gridview;
    }

    public function mr_ifram_temp_item_info_($serv)
    {
        $this->Fconnection();
        //$insert_item="INSERT INTO tmp_item_info(item_name,description,ordered_quantity,unit,price_per_unit,total_value,pr_id,vat,date)VALUES('$serv[0]','$serv[1]','$serv[2]','$serv[3]','$serv[4]','$serv[5]','$serv[6]','$serv[7]',now())";


        $insert_item = "INSERT INTO tmp_item_info_mr(item_name,description,ordered_quantity,unit,mr_id,vat,date,item_id)VALUES('$serv[0]','$serv[1]','$serv[2]','$serv[3]','$serv[4]','$serv[5]',now(),'$serv[0]')";
        //echo $insert_item;
        $result_insert = mysql_query($insert_item);
        $mr_cash_ifram_temp_item_info = mysql_fetch_array($result_insert);

    }

    public function unassigned_all_item_asset_code_mi($serv, $val2)
    {
        $this->Fconnection();

        $unique_id = uniqid();
        $asset_code = 'FAH-AST-' . $unique_id . '-ITEM-' . $serv[1] . '-S-' . '0' . '-E-' . $serv[4];

        $insert_item = "
INSERT 
INTO
    all_item_asset_code_mi
    (item_id,item_asset_code,type,cable_start,cable_end,cable_total,status,mi_id )
VALUES
    ('$serv[0]','$asset_code','$serv[2]',0,'$serv[4]','$serv[4]',0,'$val2')";
        //echo $insert_item;
        $result_insert = mysql_query($insert_item);
        $mr_cash_ifram_temp_item_info = mysql_fetch_array($result_insert);


        // Updating the availablity start end and setting the status to 0;
        $update_mi_asset_code_status = "SELECT * FROM mi_asset_code_status where mi_id like '$val2' and item_id = $serv[0] order by id desc";
        $result_mi_asset_code_status = mysql_query($update_mi_asset_code_status);
        $array_mi_asset_code_status = mysql_fetch_array($result_mi_asset_code_status);


        // Updating the the mi_asset_code_status
        // Finish one by one
        if ($array_mi_asset_code_status['qty'] == $serv[4]) {

            $update_mi_asset_code_status = "UPDATE `mi_asset_code_status` SET `status` = 1 WHERE  mi_id like '$val2' and item_id = $serv[0] order by id desc";
            $result_mi_asset_code_status = mysql_query($update_mi_asset_code_status);

        } else {

            $update_last_mi_status = "UPDATE `mi_asset_code_status` SET `status` = 1 WHERE  mi_id like '$val2' and item_id = $serv[0] order by id desc";
            $result_last_mi_status = mysql_query($update_last_mi_status);
            $new_mi_qty = $array_mi_asset_code_status['qty'] - $serv[4];
            $new_mi_item_name = $array_mi_asset_code_status['item_name'];
            $new_mi_item_name_unit = $array_mi_asset_code_status['unit'];
            $new_mi_current_item_info_final_status = $array_mi_asset_code_status['current_item_info_final_id'];
//        $new_cable_end = $array_update_availability_start_end['cable_end'] ;current_item_info_final_id

            $mi_asset_code_status_query = "insert into mi_asset_code_status (mi_id, asset_code_assign_status, date,current_item_info_final_id, item_id, item_name, qty, unit,status ) values(
'$val2', 'Asset Not Assigned', now(), $new_mi_current_item_info_final_status,'$serv[0]','$new_mi_item_name',$new_mi_qty,'$new_mi_item_name_unit', 0)";
            $insert_new_mi = mysql_query($mi_asset_code_status_query);

        }


        return true;
    }

    public function mi_piece_asset_code($serv, $val2)
    {
        $unique_id = uniqid();
        $asset_code = 'FAH-AST-UA-' . $unique_id . '-MI-' . $val2 . '-ITEM-' . $serv . '-P';
        return $asset_code;
    }

    public function unassigned_all_item_asset_code_mi_piece($serv, $val2)
    {
        $this->Fconnection();


        for ($i = 0; $i < count($serv[5]); $i++) {
            $asset_code = $serv[5][$i];
            $insert_item = "
INSERT 
INTO
    all_item_asset_code_mi
    (item_id,item_asset_code,type, status, mi_id )
VALUES
    ('$serv[0]','$asset_code','$serv[2]',0, '$val2')";
            //echo $insert_item;
            $result_insert = mysql_query($insert_item);

        }

//            $mr_cash_ifram_temp_item_info = mysql_fetch_array($result_insert);


        // Updating the availablity start end and setting the status to 0;
        $update_mi_asset_code_status = "SELECT * FROM mi_asset_code_status where mi_id like '$val2' and item_id = $serv[0] order by id desc";
        $result_mi_asset_code_status = mysql_query($update_mi_asset_code_status);
        $array_mi_asset_code_status = mysql_fetch_array($result_mi_asset_code_status);
//
//
//        // Updating the the mi_asset_code_status
        // Finish one by one
        if ((int)$array_mi_asset_code_status['qty'] == (int)$serv[4]) {

            $update_mi_asset_code_status = "UPDATE `mi_asset_code_status` SET `status` = 1 WHERE  mi_id like '$val2' and item_id = $serv[0] order by id desc";
            $result_mi_asset_code_status = mysql_query($update_mi_asset_code_status);

        } else {
//
            $update_last_mi_status = "UPDATE `mi_asset_code_status` SET `status` = 1 WHERE  mi_id like '$val2' and item_id = $serv[0] order by id desc";
            $result_last_mi_status = mysql_query($update_last_mi_status);
            $new_mi_qty = $array_mi_asset_code_status['qty'] - $serv[4];
            $new_mi_item_name = $array_mi_asset_code_status['item_name'];
            $new_mi_item_name_unit = $array_mi_asset_code_status['unit'];
            $new_mi_current_item_info_final_status = $array_mi_asset_code_status['current_item_info_final_id'];
//        $new_cable_end = $array_update_availability_start_end['cable_end'] ;current_item_info_final_id

            $mi_asset_code_status_query = "insert into mi_asset_code_status (mi_id, asset_code_assign_status, date,current_item_info_final_id, item_id, item_name, qty, unit,status ) values(
'$val2', 'Asset Not Assigned', now(), $new_mi_current_item_info_final_status,'$serv[0]','$new_mi_item_name',$new_mi_qty,'$new_mi_item_name_unit', 0)";
            $insert_new_mi = mysql_query($mi_asset_code_status_query);
//
        }

        return true;

    }

    public function assigned_all_item_asset_code_mi($serv, $val2)
    {
        $this->Fconnection();

        $insert_item = "
INSERT 
INTO
    all_item_asset_code_mi
    (item_id,item_asset_code,type,status,mi_id )
VALUES
    ('$serv[0]','$serv[1]','$serv[2]','$serv[3]', '$val2')";
        //echo $insert_item;
        $result_insert = mysql_query($insert_item);
        $mr_cash_ifram_temp_item_info = mysql_fetch_array($result_insert);

        // Updating the availablity start end and setting the status to 0;
        $update_availability_start_end = "SELECT * FROM availability_start_end where item_asset_code like '$serv[1]' order by id desc";
        $result_update_availability_start_end = mysql_query($update_availability_start_end);
        $array_update_availability_start_end = mysql_fetch_array($result_update_availability_start_end);


        $update_last = "UPDATE `availability_start_end` SET `status` = 1 WHERE item_asset_code like '$serv[1]' order by id desc";
        $result_update_last = mysql_query($update_last);


        // Updating the availablity start end and setting the status to 0;
        $update_mi_asset_code_status = "SELECT * FROM mi_asset_code_status where mi_id like '$val2' and item_id = $serv[0] order by id desc";
        $result_mi_asset_code_status = mysql_query($update_mi_asset_code_status);
        $array_mi_asset_code_status = mysql_fetch_array($result_mi_asset_code_status);

        // Updating the the mi_asset_code_status
        // Finish one by one
        if ($array_mi_asset_code_status['qty'] == 1) {

            $update_mi_asset_code_status = "UPDATE `mi_asset_code_status` SET `status` = 1 WHERE  mi_id like '$val2' and item_id = $serv[0] order by id desc";
            $result_mi_asset_code_status = mysql_query($update_mi_asset_code_status);

        } else {

            $update_last_mi_status = "UPDATE `mi_asset_code_status` SET `status` = 1 WHERE  mi_id like '$val2' and item_id = $serv[0] order by id desc";
            $result_last_mi_status = mysql_query($update_last_mi_status);
            $new_mi_qty = $array_mi_asset_code_status['qty'] - 1;
            $new_mi_item_name = $array_mi_asset_code_status['item_name'];
            $new_mi_item_name_unit = $array_mi_asset_code_status['unit'];
            $new_mi_current_item_info_final_status = $array_mi_asset_code_status['current_item_info_final_id'];
//        $new_cable_end = $array_update_availability_start_end['cable_end'] ;current_item_info_final_id

            $mi_asset_code_status_query = "insert into mi_asset_code_status (mi_id, asset_code_assign_status, date,current_item_info_final_id, item_id, item_name, qty, unit,status ) values(
'$val2', 'Asset Not Assigned', now(), $new_mi_current_item_info_final_status,'$serv[0]','$new_mi_item_name',$new_mi_qty,'$new_mi_item_name_unit', 0)";
            $insert_new_mi = mysql_query($mi_asset_code_status_query);

        }


        return true;

//        if($array_update_availability_start_end['']){
//
//
//
//        }


    }

    public function assigned_all_item_asset_code_mi_peice($serv, $val2)
    {
        $this->Fconnection();

        $insert_item = "
INSERT 
INTO
    all_item_asset_code_mi
    (item_id,item_asset_code,type,cable_id,cable_start,cable_end,cable_total,status, mi_id )
VALUES
    ('$serv[0]','$serv[1]','$serv[2]','$serv[3]','$serv[4]','$serv[5]','$serv[6]','$serv[7]','$val2')";
        //echo $insert_item;
        $result_insert = mysql_query($insert_item);
        $mr_cash_ifram_temp_item_info = mysql_fetch_array($result_insert);

        // Updating the availablity start end and setting the status to 0;
        $update_availability_start_end = "SELECT * FROM availability_start_end where item_asset_code like '$serv[1]' order by id desc";
        $result_update_availability_start_end = mysql_query($update_availability_start_end);
        $array_update_availability_start_end = mysql_fetch_array($result_update_availability_start_end);

        if ($array_update_availability_start_end['cable_total'] == $serv[6]) {
            $update_last = "UPDATE `availability_start_end` SET `status` = 1 WHERE item_asset_code like '$serv[1]' order by id desc";
            $result_update_last = mysql_query($update_last);
        } else {
            $update_last = "UPDATE `availability_start_end` SET `status` = 1 WHERE item_asset_code like '$serv[1]' order by id desc";
            $result_update_last = mysql_query($update_last);
            $new_cable_total = $array_update_availability_start_end['cable_total'] - $serv[6];
            $new_cable_end = $array_update_availability_start_end['cable_end'];

            $insert_new_available = "INSERT INTO availability_start_end ( item_id, item_asset_code,cable_total,cable_start,cable_end,status, cable_id) VALUES ('$serv[0]', '$serv[1]',$new_cable_total, '$serv[5]',$new_cable_end,0,'$serv[3]')";


            $insert_new_available_query = mysql_query($insert_new_available);
        }


        // Updating the availablity start end and setting the status to 0;
        $update_mi_asset_code_status = "SELECT * FROM mi_asset_code_status where mi_id like '$val2' and item_id = $serv[0] order by id desc";
        $result_mi_asset_code_status = mysql_query($update_mi_asset_code_status);
        $array_mi_asset_code_status = mysql_fetch_array($result_mi_asset_code_status);

        // Updating the the mi_asset_code_status
        // Finish one by one
        if ($array_mi_asset_code_status['qty'] == $serv[6]) {

            $update_mi_asset_code_status = "UPDATE `mi_asset_code_status` SET `status` = 1 WHERE  mi_id like '$val2' and item_id = $serv[0] order by id desc";
            $result_mi_asset_code_status = mysql_query($update_mi_asset_code_status);

        } else {

            $update_last_mi_status = "UPDATE `mi_asset_code_status` SET `status` = 1 WHERE  mi_id like '$val2' and item_id = $serv[0] order by id desc";
            $result_last_mi_status = mysql_query($update_last_mi_status);
            $new_mi_qty = $array_mi_asset_code_status['qty'] - $serv[6];
            $new_mi_item_name = $array_mi_asset_code_status['item_name'];
            $new_mi_item_name_unit = $array_mi_asset_code_status['unit'];
            $new_mi_current_item_info_final_status = $array_mi_asset_code_status['current_item_info_final_id'];
//        $new_cable_end = $array_update_availability_start_end['cable_end'] ;current_item_info_final_id

            $mi_asset_code_status_query = "insert into mi_asset_code_status (mi_id, asset_code_assign_status, date,current_item_info_final_id, item_id, item_name, qty, unit,status ) values(
'$val2', 'Asset Not Assigned', now(), $new_mi_current_item_info_final_status,'$serv[0]','$new_mi_item_name',$new_mi_qty,'$new_mi_item_name_unit', 0)";
            $insert_new_mi = mysql_query($mi_asset_code_status_query);

        }


//        if($array_update_availability_start_end['']){
//
//
//
//        }


    }


    // unassigned_all_item_asset_code_mi
    public function tmp_item_info_calculation_mr_($values)
    {
        $this->Fconnection();
        $sql = "select SUM(tmp_item_info_mr.total_value),vat  from tmp_item_info_mr where tmp_item_info_mr.mr_id='$values' and tmp_item_info_mr.mr_id!=''";
        //echo $sql;
        $sql_total = mysql_query("$sql");
        $total_count = mysql_fetch_row($sql_total);
        $vat = $total_count[1];
        $vat_cal = $vat / 100;
        //$total_count_vat=$total_count[0]*(0.15);
        $total_count_vat = $total_count[0] * $vat_cal;
        $total_count_vat_include = $total_count[0] + $total_count_vat;
        $count = array($total_count[0], $total_count_vat, $total_count_vat_include, $vat);
        return $count;
    }

    public function m0_item_genarel_view($serv)
    {
        $this->Fconnection();
        //$sql="SELECT pr_id,pr_type,pr_date,pr_porpuse,expense_type,meterial_type,total_estimated_cost,delivery_instruction,remarks,pr_by,license_id,co_id FROM pr_info1 where pr_tb_id<>0 $statement";
        $sql = "select (SELECT all_item_info.item_name FROM all_item_info WHERE all_item_info.item_tb_id = tmp_item_info_mr.item_name) AS item_name,tmp_item_info_mr.description,tmp_item_info_mr.ordered_quantity,tmp_item_info_mr.unit,tmp_item_info_mr.price_per_unit,tmp_item_info_mr.total_value,tmp_item_info_mr.item_tb_id,tmp_item_info_mr.mr_id FROM tmp_item_info_mr where tmp_item_info_mr.mr_id='$serv' and tmp_item_info_mr.mr_id!=''";
        //echo $sql;
        $select_m0_view = mysql_query("$sql");
        while ($m0_view_list = mysql_fetch_array($select_m0_view)) {
            $m0_view[] = $m0_view_list;
        }
        return $m0_view;
    }

    public function mr_p0_gridview_user($statement, $val, $start_from, $num_rec_per_page)
    {
        $this->Fconnection();
        $sql = "SELECT mr_id,mr_type,mr_date,mr_porpuse,expense_type,meterial_type,total_estimated_cost,delivery_instruction,remarks,mr_by,license_id,co_id FROM mr_info1
     where (tbl_tier.employee_id='$val' or  tbl_tier.tr1='$val' or  tbl_tier.tr2='$val' or tbl_tier.tr3='$val' or  tbl_tier.tr4='$val' or  tbl_tier.tr5='$val') and mr_tb_id<>0
     $statement order by mr_tb_id desc";
        //echo $sql;
        $sql1 = "SELECT
  mr_info1.mr_id,
  mr_info1.mr_type,
  mr_info1.mr_date,
  mr_info1.mr_porpuse,
  mr_info1.expense_type,
  mr_info1.meterial_type,
  mr_info1.total_estimated_cost,
  mr_info1.delivery_instruction,
  mr_info1.remarks,mr_by,
  mr_info1.license_id,
  mr_info1.co_id,
  `mr_info1`.mr_verify_by,
  `mr_info1`.mr_verify_date,
  `mr_info1`.mr_approve_by,
  `mr_info1`.mr_approval_date,
  mr_info1.employee_to
FROM
  `mr_info1`,tbl_tier
where `mr_info1`.mr_by = `tbl_tier`.employee_id
and (tbl_tier.employee_id='$val' or  tbl_tier.tr1='$val' or  tbl_tier.tr2='$val' or tbl_tier.tr3='$val' or  tbl_tier.tr4='$val' or  tbl_tier.tr5='$val' or  tbl_tier.deligation='$val' or mr_info1.employee_to='$val') and `mr_info1`.mr_tb_id<>0 and `mr_info1`.project_id !='INF03' and `mr_info1`.status=1 $statement group by mr_info1.mr_id order by `mr_info1`.mr_date desc LIMIT $start_from,$num_rec_per_page";
//echo $sql1;
        if ($_SESSION['employee_id'] == '02-1182') {
            echo $sql1;
        }
        $select_mr_p0_gridview = mysql_query("$sql1");

        return $select_mr_p0_gridview;
    }

    public function asset_not_assigned($statement, $user_emp_id, $start_from, $num_rec_per_page)
    {
        $this->Fconnection();
        $sql1 = "select * from mi_asset_code_status where status = 0 $statement";
        $select_asset_not_assigned = mysql_query("$sql1");
//        while($asset_view_list=mysql_fetch_array($select_asset_not_assigned))
//        {
//            $asset_view[]=$asset_view_list;
//        }
        return $select_asset_not_assigned;

//        return $select_asset_not_assigned;

    }


    public function district_wise_mr_gridview($statement, $val, $start_from, $num_rec_per_page)
    {
        $this->Fconnection();
        $sql = "SELECT mr_id,mr_type,mr_date,mr_porpuse,expense_type,meterial_type,total_estimated_cost,delivery_instruction,remarks,mr_by,license_id,co_id FROM mr_info1
     where (tbl_tier.employee_id='$val' or  tbl_tier.tr1='$val' or  tbl_tier.tr2='$val' or tbl_tier.tr3='$val' or  tbl_tier.tr4='$val' or  tbl_tier.tr5='$val') and mr_tb_id<>0
     $statement order by mr_tb_id desc";
        //echo $sql;
        $sql1 = "SELECT
  mr_info1.mr_id,
  mr_info1.mr_type,
  mr_info1.mr_date,
  mr_info1.mr_porpuse,
  mr_info1.expense_type,
  mr_info1.meterial_type,
  mr_info1.total_estimated_cost,
  mr_info1.delivery_instruction,
  mr_info1.remarks,mr_by,
  mr_info1.license_id,
  mr_info1.co_id,
  `mr_info1`.mr_verify_by,
  `mr_info1`.mr_verify_date,
  `mr_info1`.mr_approve_by,
  `mr_info1`.mr_approval_date,
  mr_info1.employee_to,
  mr_info1.district
FROM
  `mr_info1`
where mr_info1.district in($val)  and `mr_info1`.mr_tb_id<>0  $statement group by mr_info1.mr_id order by `mr_info1`.mr_date desc LIMIT $start_from,$num_rec_per_page";
//echo $sql1;
        $select_mr_p0_gridview = mysql_query("$sql1");
        /*
     while($mr_p0_gridview_list=mysql_fetch_array($select_mr_p0_gridview))
     {
       $mr_p0_gridview[]=$mr_p0_gridview_list;
     }
	 */
        return $select_mr_p0_gridview;
    }


    public function mr_p0_gridview_user_infosarkar($statement, $val, $start_from, $num_rec_per_page)
    {
        $this->Fconnection();
        $sql = "SELECT mr_id,mr_type,mr_date,mr_porpuse,expense_type,meterial_type,total_estimated_cost,delivery_instruction,remarks,mr_by,license_id,co_id,employee_to FROM mr_info1
     where (tbl_tier.employee_id='$val' or  tbl_tier.tr1='$val' or  tbl_tier.tr2='$val' or tbl_tier.tr3='$val' or  tbl_tier.tr4='$val' or  tbl_tier.tr5='$val') and mr_tb_id<>0 '
     $statement order by mr_tb_id desc";
        //echo $sql;
        $sql1 = "SELECT
  mr_info1.mr_id,
  mr_info1.mr_type,
  mr_info1.mr_date,
  mr_info1.mr_porpuse,
  mr_info1.expense_type,
  mr_info1.meterial_type,
  mr_info1.total_estimated_cost,
  mr_info1.delivery_instruction,
  mr_info1.remarks,mr_info1.mr_by,
  mr_info1.license_id,
  mr_info1.co_id,
  `mr_info1`.mr_verify_by,
  `mr_info1`.mr_verify_date,
  `mr_info1`.mr_approve_by,
  `mr_info1`.mr_approval_date,
  `tbl_tier`.employee_id,
  `mr_info1`.district,
  `mr_info1`.upazilla_id,
  `mr_info1`.union_id,
  mr_info1.employee_to

FROM
  `mr_info1`,tbl_tier
where `mr_info1`.mr_by = `tbl_tier`.employee_id
and (tbl_tier.employee_id='$val' or  tbl_tier.tr1='$val' or  tbl_tier.tr2='$val' or tbl_tier.tr3='$val' or  tbl_tier.tr4='$val' or  tbl_tier.tr5='$val' or  tbl_tier.deligation='$val' or  mr_info1.employee_to='$val') and `mr_info1`.mr_tb_id<>0 and `mr_info1`.status=1 and mr_info1.project_id='INF03' $statement group by mr_info1.mr_id order by `mr_info1`.mr_date desc LIMIT $start_from,$num_rec_per_page";
//echo $sql1;
        $select_mr_p0_gridview = mysql_query("$sql1");

        return $select_mr_p0_gridview;
    }


    public function mr_p0_gridview_all($statement)
    {
        $this->Fconnection();
        $sql = "SELECT mr_id,mr_type,mr_date,mr_porpuse,expense_type,meterial_type,total_estimated_cost,delivery_instruction,remarks,mr_by,license_id,co_id FROM mr_info1
     where mr_tb_id<>0
     $statement order by mr_tb_id desc";
        //echo $sql;
        $sql1 = "
SELECT
  mr_info1.mr_id,
  mr_info1.mr_type,
  mr_info1.mr_date,
  mr_info1.mr_porpuse,
  mr_info1.expense_type,
  mr_info1.meterial_type,
  mr_info1.total_estimated_cost,
  mr_info1.delivery_instruction,
  mr_info1.remarks,mr_info1.mr_by,
  mr_info1.license_id,
  mr_info1.co_id,
  `mr_info1`.mr_verify_by,
  `mr_info1`.mr_verify_date,
  `mr_info1`.mr_approve_by,
  `mr_info1`.mr_approval_date,
  `tbl_tier`.employee_id
FROM
  `mr_info1`,tbl_tier
where `mr_info1`.mr_by = `tbl_tier`.employee_id
and `mr_info1`.mr_tb_id<>0 $statement group by mr_info1.mr_id order by `mr_info1`.mr_tb_id desc
";
//echo $sql1;
        $select_mr_p0_gridview_all = mysql_query("$sql1");
        while ($mr_p0_gridview_list_all = mysql_fetch_array($select_mr_p0_gridview_all)) {
            $mr_p0_gridview_all[] = $mr_p0_gridview_list_all;
        }
        return $mr_p0_gridview_all;
    }


    public function count_mr_p0_gridview_all()
    {
        $this->Fconnection();
        $sql1 = "SELECT
  mr_info1.mr_id,
  mr_info1.mr_type,
  mr_info1.mr_date,
  mr_info1.mr_porpuse,
  mr_info1.expense_type,
  mr_info1.meterial_type,
  mr_info1.total_estimated_cost,
  mr_info1.delivery_instruction,
  mr_info1.remarks,mr_info1.mr_by,
  mr_info1.license_id,
  mr_info1.co_id,
  `mr_info1`.mr_verify_by,
  `mr_info1`.mr_verify_date,
  `mr_info1`.mr_approve_by,
  `mr_info1`.mr_approval_date,
  `tbl_tier`.employee_id
FROM
  `mr_info1`,tbl_tier
where `mr_info1`.mr_by = `tbl_tier`.employee_id
and `mr_info1`.mr_tb_id<>0 $statement group by mr_info1.mr_id order by `mr_info1`.mr_tb_id desc";
        //echo $sql1;
        $select_all_item_sql1 = mysql_query("$sql1");
        $total_rows = mysql_num_rows($select_all_item_sql1);
        return $total_rows;
    }

//pagination function
    public function mr_p0_gridview_all_pagination($statement, $start_from, $num_rec_per_page)
    {
        $this->Fconnection();
        $sql = "SELECT mr_id,mr_type,mr_date,mr_porpuse,expense_type,meterial_type,total_estimated_cost,delivery_instruction,remarks,mr_by,license_id,co_id FROM mr_info1
     where mr_tb_id<>0
     $statement order by mr_tb_id desc";
        //echo $sql;
        $sql1 = "SELECT
  mr_info1.mr_id,
  mr_info1.mr_type,
  mr_info1.mr_date,
  mr_info1.mr_porpuse,
  mr_info1.expense_type,
  mr_info1.meterial_type,
  mr_info1.total_estimated_cost,
  mr_info1.delivery_instruction,
  mr_info1.remarks,mr_info1.mr_by,
  mr_info1.license_id,
  mr_info1.co_id,
  `mr_info1`.mr_verify_by,
  `mr_info1`.mr_verify_date,
  `mr_info1`.mr_approve_by,
  `mr_info1`.mr_approval_date,
  `mr_info1`.employee_to,
  `tbl_tier`.employee_id,
    `mr_info1`.project_id

FROM
  `mr_info1`,tbl_tier
where `mr_info1`.mr_by = `tbl_tier`.employee_id
and `mr_info1`.mr_tb_id<>0  $statement  order by `mr_info1`.mr_tb_id desc  LIMIT $start_from, $num_rec_per_page";
//echo $sql1;

        $select_mr_p0_gridview_all = mysql_query("$sql1");

        return $select_mr_p0_gridview_all;


    }

    //


    public function mr_p0_view_($table_mr_info1, $mr_id)
    {
        $this->Fconnection();
        //$pr_p0_details_sql=mysql_query("SELECT pr_id,pr_type,pr_date,pr_porpuse,expense_type,meterial_type,total_estimated_cost,delivery_instruction,remarks,pr_by,license_id,co_id FROM pr_info1 where pr_id='$pr_id'");

        $mr_p0_details_sql = mysql_query("SELECT mr_id,mr_type,mr_date,mr_porpuse,expense_type,meterial_type,total_estimated_cost,delivery_instruction,remarks,mr_by,license_id,co_id,project_id,project_id_new,project_id_new_for,exp_description,expected_date,employee_to,district,upazilla_id,union_id ,local_co_id,co_id FROM $table_mr_info1 where mr_id='$mr_id'");
        //echo "SELECT mr_id,mr_type,mr_date,mr_porpuse,expense_type,meterial_type,total_estimated_cost,delivery_instruction,remarks,mr_by,license_id,co_id,project_id,project_id_new,project_id_new_for,exp_description,expected_date,employee_to,district,upazilla_id,union_id ,local_co_id FROM $table_mr_info1 where mr_id='$mr_id'";
        //echo "SELECT mr_id,mr_type,mr_date,mr_porpuse,expense_type,meterial_type,total_estimated_cost,delivery_instruction,remarks,mr_by,license_id,co_id,project_id,project_id_new,project_id_new_for,exp_description,expected_date,employee_to,district,upazilla_id,union_id ,local_co_id FROM $table_mr_info1 where mr_id='$mr_id'";
        $mr_p0_info = mysql_fetch_array($mr_p0_details_sql);

        return $mr_p0_info;
    }

    public function mr_p0_p1_view_($table_mr_info1, $mr_id)
    {
        $this->Fconnection();
        $sql = "SELECT mr_id,tb_s1,tb_s2,tb_s3,tb_s4,tb_s5,tb_s6,tb_s7,tb_s8,tb_s9,tb_s10,tb_s11,tb_s12,comments,`status`,user,comments2 FROM mr_info3 where mr_id='$mr_id'";
        //echo $sql;
        $mr_p0_p1_details_sql = mysql_query("$sql");
        $mr_p0_p1_info = mysql_fetch_array($mr_p0_p1_details_sql);
        return $mr_p0_p1_info;
    }


//

    public function mr_p0_p1_view_pagination($mr_id)
    {
        $this->Fconnection();
        $sql = "SELECT mr_id,tb_s1,tb_s2,tb_s3,tb_s4,tb_s5,tb_s6,tb_s7,tb_s8,tb_s9,tb_s10,tb_s11,tb_s12,comments,`status`,user,comments2 FROM mr_info3 where mr_id='$mr_id'";
        //echo $sql;
        $mr_p0_p1_details_sql = mysql_query("$sql");
        $mr_p0_p1_info = mysql_fetch_array($mr_p0_p1_details_sql);
        return $mr_p0_p1_info;
    }

    //


    /*public function current_item_info_fainal_unique_mr_infosarkar_all_data($val)
  {
     $this->Fconnection();

     $sql="select * from current_item_info_fainal_infosarkar where mr_id='$val'";
    //echo "$sql";
     $scm_approval_tree_sql_mr=mysql_query("$sql");
     $scm_approval_tree_mr=mysql_fetch_array($scm_approval_tree_sql_mr);
    return $scm_approval_tree_mr;
  }
*/


    public function scm_approval_tree_unique_mr($val)
    {
        $this->Fconnection();

        $sql = "select * from scm_approval_tree_inventory where mr_id='$val'";
        //echo "$sql";
        $scm_approval_tree_sql_mr = mysql_query("$sql");
        $scm_approval_tree_mr = mysql_fetch_array($scm_approval_tree_sql_mr);
        return $scm_approval_tree_mr;
    }

    public function current_item_info_fainal_unique_mr($val)
    {
        $this->Fconnection();
        $today = date("Y-m-d");
        //$val=$_SESSION['employee_id'];
        $sql = "select mr_id,mi_id from  current_item_info_fainal where mr_id='$val' and mi_id!='' group by mi_id";
        //echo $sql;
        $select_mi_p0_gridview = mysql_query("$sql");
        while ($mi_p0_gridview_list = mysql_fetch_array($select_mi_p0_gridview)) {
            $mi_p0_gridview[] = $mi_p0_gridview_list;
        }
        return $mi_p0_gridview;

    }


    public function current_item_info_fainal_unique_mr_infosarkar($val)
    {
        $this->Fconnection();
        $today = date("Y-m-d");
        //$val=$_SESSION['employee_id'];
        $sql = "select * from  current_item_info_fainal_infosarkar where mr_id='$val' and mi_id!='' group by mi_id";
        //echo $sql;
        $select_mi_p0_gridview = mysql_query("$sql");
        while ($mi_p0_gridview_list = mysql_fetch_array($select_mi_p0_gridview)) {
            $mi_p0_gridview[] = $mi_p0_gridview_list;
        }

        return $mi_p0_gridview;


    }


    public function mr0_line_man($val)
    {
        $this->Fconnection();

        $sql = "update mr_info3 set comments2='$val[5]' where mr_id='$val[0]'";
        //echo "$sql";
        $mr0_line_man = mysql_query("$sql");
        $scm_line_man_mr = mysql_fetch_array($mr0_line_man);
        return $scm_line_man_mr;
    }

    public function mr0_review($values)
    {
        $this->Fconnection();
        $today = date("Y-m-d");
        $mr0_sql = "update scm_approval_tree_inventory set pr_31='$values[1]' where mr_id='$values[0]'";
        //echo $pr0_sql;
        $mr0_add_sql = mysql_query("$mr0_sql");

        $review_mr0_sql = mysql_fetch_array("$mr0_add_sql");
        return $review_mr0_sql;
    }

    public function mr0_approval_line_man($val)
    {
        $this->Fconnection();

        $sql = "update scm_approval_tree_inventory set mr_approval_l1='$val[2]',mr_approval_l1_date='$val[1]',mr_approval_l2='$val[4]',mr_approval_l2_date='$val[3]'   where mr_id='$val[0]'";
        //echo "$sql";
        $mr0_approval_line_man = mysql_query("$sql");
        $scm_approval_line_man_mr = mysql_fetch_array($mr0_approval_line_man);
        return $scm_approval_line_man_mr;
    }

    public function mr2_add_info($values)
    {
        $this->Fconnection();
        $today = date("Y-m-d");
        $sql_query = "insert into mr_info3 (mr_id,tb_s1,tb_s2,tb_s3,tb_s4,tb_s5,tb_s6,tb_s7,tb_s8,tb_s9,tb_s10,tb_s11,tb_s12,comments,`status`,user)
values ('$values[0]','$values[1]','$values[2]','$values[3]','$values[4]','$values[5]','$values[6]','$values[7]','$values[8]','$values[9]','$values[10]','$values[11]','$values[12]','$values[13]','$values[14]','$values[15]')";
//echo $sql_query;
        $mr2_add_sql = mysql_query("$sql_query");

        $insert_mr2_sql = mysql_fetch_array($mr2_add_sql);
        return $insert_mr2_sql;
    }

    ///////////////////////////////////MR Report User///////////////////////////////////
    public function mr_user_report($val, $statement)
    {
        $this->Fconnection();
        $today = date("Y-m-d");
        //and (tbl_tier.employee_id='$val' or  tbl_tier.tr1='$val' or  tbl_tier.tr2='$val' or tbl_tier.tr3='$val' or  tbl_tier.tr4='$val' or  tbl_tier.tr5='$val' or  tbl_tier.deligation='$val') and `mr_info1`.mr_tb_id<>0 $statement";

        //$val=$_SESSION['employee_id'];
        $sql = "SELECT mr_info1.mr_id,mr_info1.mr_by,mr_info1.mr_approval_l1,mr_info1.mr_approval_l1_date,mr_info1.mr_approval_l2,mr_info1.mr_approval_l2_date,mr_info1.mr_approval_l3,mr_info1.mr_approval_l3_date,mr_info1.employee_to,mr_info1.project_id,tmp_item_info_mr.item_id,tmp_item_info_mr.item_id,tmp_item_info_mr.ordered_quantity,tmp_item_info_mr.unit,tmp_item_info_mr.item_id,mr_info1.delivery_instruction
    FROM tmp_item_info_mr,mr_info1,tbl_tier
    WHERE mr_info1.mr_id=tmp_item_info_mr.mr_id AND mr_info1.mr_id!='' and `mr_info1`.mr_by = `tbl_tier`.employee_id $statement";
        //echo $sql;
        $select_mi_p0_gridview = mysql_query("$sql");
        while ($mi_p0_gridview_list = mysql_fetch_array($select_mi_p0_gridview)) {
            $mi_p0_gridview[] = $mi_p0_gridview_list;
        }
        return $mi_p0_gridview;


    }


    public function mr_user_report_pagination($val, $statement, $start_from, $num_rec_per_page)
    {
        $this->Fconnection();
        $today = date("Y-m-d");
        //and (tbl_tier.employee_id='$val' or  tbl_tier.tr1='$val' or  tbl_tier.tr2='$val' or tbl_tier.tr3='$val' or  tbl_tier.tr4='$val' or  tbl_tier.tr5='$val' or  tbl_tier.deligation='$val') and `mr_info1`.mr_tb_id<>0 $statement";

        //$val=$_SESSION['employee_id'];
        $sql = "SELECT mr_info1.mr_id,
    mr_info1.mr_by,
    mr_info1.mr_approval_l1,
    mr_info1.mr_approval_l1_date,
    mr_info1.mr_approval_l2,
    mr_info1.mr_approval_l2_date,
    mr_info1.mr_approval_l3,
    mr_info1.mr_approval_l3_date,
    mr_info1.employee_to,
    mr_info1.project_id,
    tmp_item_info_mr.item_id,
    tmp_item_info_mr.item_id,
    tmp_item_info_mr.ordered_quantity,
    tmp_item_info_mr.unit,
    tmp_item_info_mr.item_id,
    mr_info1.delivery_instruction
    FROM tmp_item_info_mr,mr_info1
    WHERE mr_info1.mr_id=tmp_item_info_mr.mr_id AND mr_info1.mr_id!='' and  $statement LIMIT $start_from, $num_rec_per_page";
        //echo $sql;
        $select_mi_p0_gridview = mysql_query("$sql");

        /*

     while($mi_p0_gridview_list=mysql_fetch_array($select_mi_p0_gridview))
     {
       $mi_p0_gridview[]=$mi_p0_gridview_list;
     }

*/

        return $select_mi_p0_gridview;


    }


    public function count_mr_user_report_totoal_rows()
    {
        $this->Fconnection();
        $today = date("Y-m-d");
        //and (tbl_tier.employee_id='$val' or  tbl_tier.tr1='$val' or  tbl_tier.tr2='$val' or tbl_tier.tr3='$val' or  tbl_tier.tr4='$val' or  tbl_tier.tr5='$val' or  tbl_tier.deligation='$val') and `mr_info1`.mr_tb_id<>0 $statement";

        //$val=$_SESSION['employee_id'];
        $sql = "SELECT mr_info1.mr_id,mr_info1.mr_by,mr_info1.mr_approval_l1,mr_info1.mr_approval_l1_date,mr_info1.mr_approval_l2,mr_info1.mr_approval_l2_date,mr_info1.mr_approval_l3,mr_info1.mr_approval_l3_date,mr_info1.employee_to,mr_info1.project_id,tmp_item_info_mr.item_id,tmp_item_info_mr.item_id,tmp_item_info_mr.ordered_quantity,tmp_item_info_mr.unit,tmp_item_info_mr.item_id,mr_info1.delivery_instruction
    FROM tmp_item_info_mr,mr_info1,tbl_tier
    WHERE mr_info1.mr_id=tmp_item_info_mr.mr_id AND mr_info1.mr_id!='' and `mr_info1`.mr_by = `tbl_tier`.employee_id ";
        //echo $sql;
        $select_mi_p0_gridview = mysql_query("$sql");

        return $select_mi_p0_gridview;


    }






    ///////////////////////////////////MR Report User///////////////////////////////////
    /////////////////////////////////////////////MR//////////////////////////////////////////////////
    /////////////////////////////////////////////GRMI//////////////////////////////////////////////////

    public function gr_auto_gen_()
    {
        $this->Fconnection();
        $today = date("Y-m-d");
        //$val=$_SESSION['employee_id'];
        $sql = "select max(id) from  current_item_info_fainal";
        //echo $sql;
        $grn_gen_max = mysql_query($sql);
        $grn_max_no = mysql_fetch_row($grn_gen_max);
        $a = $grn_max_no[0] + 1;
        $increment_value_grn = 'FAHSC' . $today . 'GR' . $a;
        return $increment_value_grn;

    }

    public function gr_auto_gen_infosarkar()
    {
        $this->Fconnection();
        $today = date("Y-m-d");
        $val = $_SESSION['employee_id'];
        $sql = "SELECT * FROM  current_item_info_fainal_infosarkar  where gr_id !='' group by gr_id";
        //echo $sql;
        $grn_gen_max = mysql_query($sql);
        $max = mysql_num_rows($grn_gen_max);
        // $grn_max_no=mysql_fetch_row($grn_gen_max);
        $a = $max + 1;
        $increment_value_grn = 'FAHINFO3' . $val . $today . 'GR' . $a;
        return $increment_value_grn;

    }


    public function item_info_indv_maxid($val)
    {
        $this->Fconnection();
        $today = date("Y-m-d");
        //$val=$_SESSION['employee_id'];

        //$sql="select item_id,qty,max(id), from  current_item_info_fainal where item_id='$val'";
        $sql = "SELECT tt.item_tb_id,tt.qty,tt.id,tt.group_id,tt.group,tt.item_code_inv,tt.item_name,tt.main_group_account 
          FROM current_item_info_fainal tt 
          INNER JOIN (SELECT item_tb_id, MAX(id) AS id1 FROM current_item_info_fainal GROUP BY item_tb_id) cciif 
          ON tt.item_tb_id = cciif.item_tb_id 
          AND tt.id = cciif.id1 
          AND tt.item_id='$val' 
          ORDER BY tt.item_name";
        //echo $sql;
        $max = mysql_query($sql);
        $max_no = mysql_fetch_row($max);
        return $max_no;

    }

    public function item_info_indv_maxid_infosarkar($val)
    {
        $this->Fconnection();
        $today = date("Y-m-d");
        //$val=$_SESSION['employee_id'];

        //$sql="select item_id,qty,max(id), from  current_item_info_fainal where item_id='$val'";
        $sql = "SELECT tt.item_tb_id,tt.qty,tt.id,tt.group_id,tt.group,tt.item_code_inv,tt.item_name,tt.main_group_account FROM current_item_info_fainal_infosarkar tt INNER JOIN (SELECT item_tb_id, MAX(id) AS id1 FROM current_item_info_fainal_infosarkar GROUP BY item_tb_id) cciif ON tt.item_tb_id = cciif.item_tb_id AND tt.id = cciif.id1 AND tt.item_id='$val' ORDER BY tt.item_name";
        //echo $sql;
        $max = mysql_query($sql);
        $max_no = mysql_fetch_row($max);
        return $max_no;

    }


    public function item_info_indv_maxid_local_co($val, $local_co_id)
    {
        $this->Fconnection();
        $today = date("Y-m-d");
        //$val=$_SESSION['employee_id'];

        //$sql="select item_id,qty,max(id), from  current_item_info_fainal where item_id='$val'";
        $sql = "SELECT tt.item_tb_id,tt.qty,tt.id,tt.group_id,tt.group,tt.item_code_inv,tt.item_name,tt.main_group_account FROM current_item_info_fainal_local_co tt INNER JOIN (SELECT item_tb_id, MAX(id) AS id1 FROM current_item_info_fainal_local_co GROUP BY item_tb_id) cciif ON tt.item_tb_id = cciif.item_tb_id  AND tt.item_id='$val' and tt.local_co_id='$local_co_id'  ORDER BY tt.id desc limit 1";
        // echo $sql;
        $max = mysql_query($sql);
        $max_no = mysql_fetch_row($max);
        return $max_no;

    }

    public function item_info_indv_maxid_local_co_infosarkar($item_id, $local_co_id)
    {
        $this->Fconnection();
        $today = date("Y-m-d");
        //$val=$_SESSION['employee_id'];

        //$sql="select item_id,qty,max(id), from  current_item_info_fainal where item_id='$val'";
        $sql = "SELECT tt.item_tb_id,tt.qty,tt.id,tt.group_id,tt.group,tt.item_code_inv,tt.item_name,tt.main_group_account FROM current_item_info_fainal_local_co_infosarkar tt INNER JOIN (SELECT item_tb_id, MAX(id) AS id1 FROM current_item_info_fainal_local_co_infosarkar WHERE  local_co_id='$local_co_id' GROUP BY item_tb_id) cciif ON tt.item_tb_id = cciif.item_tb_id AND tt.id = cciif.id1 AND tt.item_id='$item_id' ORDER BY tt.item_name";
        //echo $sql;
        $max = mysql_query($sql);
        $max_no = mysql_fetch_row($max);
        return $max_no;

    }

    public function gr_info_add($values)
    {
        $this->Fconnection();

        $sql = mysql_query("SELECT *  FROM  all_item_info WHERE item_id = '$values[1]'");
        $unit_val = mysql_fetch_row($sql);

        $today = date("Y-m-d");
        $sql_query = "insert into current_item_info_fainal (item_tb_id,item_id,item_name,qty,unit,sub_group,sub_group_id,`group`,group_id,unit_price,total_value,datei,in_out_status,user_id,pr_id,pq_id,po_id,project_id,licence_id,project_id_exp,vandor_id,`status`,expence_type,gr_id,request_qty,previous_qty)
values ('$values[0]','$values[1]','$values[2]','$values[3]','$unit_val[9]','$values[5]','$values[6]','$values[7]','$values[8]','$values[9]','$values[10]','$values[11]','$values[12]','$values[13]','$values[14]','$values[15]','$values[16]','$values[17]','$values[18]','$values[19]','$values[20]','$values[21]','$values[22]','$values[23]','$values[24]','$values[25]')";
//echo $sql_query;
        $gr_add_sql = mysql_query("$sql_query");

        $gr_add_item = 'SELECT id, gr_id FROM current_item_info_fainal WHERE gr_id like "' . $values[23] . '" ORDER BY id DESC LIMIT 1';
        $gr_add_item_query = mysql_query("$gr_add_item");
        $gr_add_item_data = mysql_fetch_array($gr_add_item_query);
        $gr_by = $_SESSION['employee_id'];

        if ($values[27] == 'optical cable') {
            $total = $values[30] - $values[29];
            $today = uniqid();
            $asset_code = 'FAH-AST-' . $today . '-GR-' . $gr_add_item_data[1] . '-ITEM-' . $values[1] . '-S-' . $values[29] . '-E-' . $values[30];

            $insertAssetCode = ("INSERT INTO all_item_asset_code ( item_id, item_asset_code, gr_id, gr_table_key,type,cable_id,cable_start,cable_end,cable_total,status,gr_done_by) VALUES ('$values[1]', '$asset_code', '$gr_add_item_data[1]',  '$gr_add_item_data[0]' , '$values[27]','$values[28]','$values[29]','$values[30]',$total,0,'$gr_by')");

            $insert_gr_query = mysql_query("$insertAssetCode");


            $insert_availablity_start_end = ("INSERT INTO availability_start_end ( item_id, item_asset_code,cable_total,cable_start,cable_end,status,cable_id) VALUES ('$values[1]', '$asset_code',$total, '$values[29]','$values[30]',0,'$values[28]' )");

            $insert_availablity_start_end_query = mysql_query("$insert_availablity_start_end");

        } else {

//                $insertAssetCode = "INSERT INTO table_name ( item_id, item_asset_code,gr_id,gr_table_key,type,cable_id,cable_start,cable_end,cable_total,status,gr_done_by) VALUES ('$values[1]', array_values($values[26][$i]), '$gr_add_item_data[1]', array_values($gr_add_item_data[0][$i]) , '$values[27]','$values[28]','$values[29]','$values[30]',0,'$gr_by')";


            for ($i = 1; $i <= count($values[26]); ++$i) {

                $theItemAssetCodeValue = $values[26];
                $insertAssetCodeSt = "INSERT INTO all_item_asset_code ( item_id, item_asset_code,gr_id,gr_table_key,type,cable_id,cable_start,cable_end,cable_total,status,gr_done_by) VALUES ('$values[1]', '$theItemAssetCodeValue[$i]' , '$gr_add_item_data[1]', $gr_add_item_data[0] , '$values[27]','$values[28]','$values[29]','$values[30]','',0,'$gr_by')";

                $insert_gr_query_asset = mysql_query("$insertAssetCodeSt");


                $insert_availablity_start_end_itm = ("INSERT INTO availability_start_end ( item_id, item_asset_code,status) VALUES ('$values[1]', '$theItemAssetCodeValue[$i]',0 )");

                $insert_availablity_start_end_query = mysql_query("$insert_availablity_start_end_itm");
            }

        }


        $insert_gr_sql = mysql_fetch_array($gr_add_sql);


        return $insert_gr_sql;
    }

    public function gr_info_add_note($values)
    {
        $this->Fconnection();
        $today = date("Y-m-d");
        $sql_query = "insert into current_item_info_fainal_note (transection_id,transection_note,`user`,`date`,status)
values ('$values[0]','$values[1]','$values[2]','$values[3]','$values[4]')";
//echo $sql_query;
        $gr_add_sql = mysql_query("$sql_query");

        $insert_gr_sql = mysql_fetch_array($gr_add_sql);
        return $insert_gr_sql;
    }

    public function gr_info_add_infosarkar($values)
    {
        $this->Fconnection();
        $today = date("Y-m-d");

        $sql = mysql_query("SELECT *  FROM  all_item_info WHERE item_id = '$values[0]'");
        $unit_val = mysql_fetch_row($sql);

        $sql_query = "insert into current_item_info_fainal_infosarkar (item_tb_id,item_id,item_name,qty,unit,sub_group,sub_group_id,`group`,group_id,unit_price,total_value,datei,in_out_status,user_id,pr_id,pq_id,po_id,project_id,licence_id,project_id_exp,vandor_id,`status`,expence_type,gr_id,request_qty,previous_qty,item_code_inv,note,district,huwaei_id_bom_no,main_group_account) values ('$values[0]','$values[1]','$values[2]','$values[3]','$values[4]','$values[5]','$values[6]','$unit_val[5]','$unit_val[6]','$values[9]','$values[10]','$values[11]','$values[12]','$values[13]','$values[14]','$values[15]','$values[16]','$values[17]','$values[18]','$values[19]','$values[20]','$values[21]','$values[22]','$values[23]','$values[24]','$values[25]','$unit_val[21]','$values[27]','$values[28]','$unit_val[29]','$unit_val[23]')";
//echo $sql_query;
        $gr_add_sql = mysql_query("$sql_query");

        $insert_gr_sql = mysql_fetch_array($gr_add_sql);
        return $insert_gr_sql;
    }

    public function gr_info_add_infosarkar_dir_gr($values)
    {
        $this->Fconnection();

        $sql = mysql_query("SELECT *  FROM  all_item_info WHERE item_id = '$values[1]'");
        $unit_val = mysql_fetch_row($sql);

        $today = date("Y-m-d");
        $sql_query = "insert into current_item_info_fainal_infosarkar (item_tb_id,item_id,item_name,qty,unit,`group`,group_id,datei,in_out_status,user_id,project_id,licence_id,vandor_id,ref_no,gr_id, lc_no , item_code_inv , main_group_account ,request_qty,previous_qty,note) values ('$values[0]','$values[1]','$values[2]','$values[3]','$unit_val[9]','$values[5]','$values[6]','$values[7]','$values[8]','$values[9]','$values[10]','$values[11]','$values[12]','$values[13]','$values[14]','$values[15]','$values[16]','$values[17]','$values[18]','$values[19]','$values[20]')";
//echo $sql_query;
        $gr_add_sql = mysql_query("$sql_query");

        $insert_gr_sql = mysql_fetch_array($gr_add_sql);
        return $insert_gr_sql;
    }


    public function gr_info_add_infosarkar_dir_gr_file_upload($values)
    {
        $this->Fconnection();
        $today = date("Y-m-d");
        $sql_query = "insert into tbl_gr_file_list_infosarker (gr_no,file) values ('$values[0]','$values[1]')";
//echo $sql_query;
        $gr_add_sql = mysql_query("$sql_query");

        $insert_gr_sql = mysql_fetch_array($gr_add_sql);
        return $insert_gr_sql;
    }


    public function gr_info_add_infosarkar_dir_gr_show_single_gr($values)
    {
        $this->Fconnection();
        $today = date("Y-m-d");
        $sql_query = "insert into current_item_info_fainal_infosarkar_show_single_gr (item_tb_id,item_id,item_name,qty,unit,`group`,group_id,datei,in_out_status,user_id,project_id,licence_id,vandor_id,ref_no,gr_id, lc_no , item_code_inv , main_group_account ,request_qty,previous_qty,note) values ('$values[0]','$values[1]','$values[2]','$values[3]','$values[4]','$values[5]','$values[6]','$values[7]','$values[8]','$values[9]','$values[10]','$values[11]','$values[12]','$values[13]','$values[14]','$values[15]','$values[16]','$values[17]','$values[18]','$values[19]','$values[20]')";
//echo $sql_query;
        $gr_add_sql = mysql_query("$sql_query");

        $insert_gr_sql = mysql_fetch_array($gr_add_sql);
        return $insert_gr_sql;
    }


    public function po_wise_gr_info($val)
    {
        $this->Fconnection();
        $today = date("Y-m-d");
        //$val=$_SESSION['employee_id'];
        $sql = "select po_id,gr_id from  current_item_info_fainal where po_id='$val' and po_id!='' group by gr_id";
        //echo $sql;
        $select_mi_p0_gridview = mysql_query("$sql");
        while ($mi_p0_gridview_list = mysql_fetch_array($select_mi_p0_gridview)) {
            $mi_p0_gridview[] = $mi_p0_gridview_list;
        }
        return $mi_p0_gridview;

    }

    public function po_wise_gr_info_infosarkar($val)
    {
        $this->Fconnection();
        $today = date("Y-m-d");
        //$val=$_SESSION['employee_id'];
        $sql = "select po_id,gr_id from  current_item_info_fainal_infosarkar where po_id='$val' and po_id!='' group by gr_id";
        //echo $sql;
        $select_mi_p0_gridview = mysql_query("$sql");
        while ($mi_p0_gridview_list = mysql_fetch_array($select_mi_p0_gridview)) {
            $mi_p0_gridview[] = $mi_p0_gridview_list;
        }
        return $mi_p0_gridview;

    }

    public function mi_wise_rq_info_infosarkar($val)
    {
        $this->Fconnection();
        $today = date("Y-m-d");
        //$val=$_SESSION['employee_id'];
        $sql = "select mi_id,rq_id from  current_item_info_fainal_local_co_infosarkar where mi_id='$val' and rq_id!='' group by rq_id";
        //echo $sql;
        $select_mi_p0_gridview = mysql_query("$sql");
        while ($mi_p0_gridview_list = mysql_fetch_array($select_mi_p0_gridview)) {
            $mi_p0_gridview[] = $mi_p0_gridview_list;
        }
        return $mi_p0_gridview;

    }


    public function mi_wise_rq_info_infosarkar2($val)
    {
        $this->Fconnection();
        $today = date("Y-m-d");
        //$val=$_SESSION['employee_id'];
        $sql = "select mi_id,rq_id from  current_item_info_fainal_local_co_infosarkar where mi_id='$val' and rq_id!='' group by rq_id";
        //echo $sql;
        $select_mi_p0_gridview = mysql_query("$sql");

        return $select_mi_p0_gridview;

    }


    public function rq_wise_usage_info_infosarkar($val)
    {
        $this->Fconnection();
        $today = date("Y-m-d");
        //$val=$_SESSION['employee_id'];
        $sql = "select mi_id,rq_id from  current_item_info_fainal_local_co_infosarkar where mi_id='$val' and rq_id!='' group by rq_id";
        // echo $sql;
        $select_mi_p0_gridview = mysql_query("$sql");

        return $select_mi_p0_gridview;

    }

    /////////////////////////////////////////////GRMI//////////////////////////////////////////////////
    ///////////////////Current_temm////////////////
    public function current_stock($val)
    {
        $this->Fconnection();
        //$sql="select * from current_item_info_fainal where item_id='$val'";
        $sql = "SELECT tt.item_tb_id,tt.item_name,tt.qty,tt.id FROM current_item_info_fainal tt INNER JOIN (SELECT item_tb_id, MAX(id) AS id1 FROM current_item_info_fainal GROUP BY item_tb_id) cciif ON tt.item_tb_id = cciif.item_tb_id AND tt.id = cciif.id1 AND tt.item_tb_id='$val' ORDER BY tt.item_name";
        //echo $sql;
        $current_stock = mysql_query("$sql");
        $current_stock_a = mysql_fetch_array($current_stock);
        return $current_stock_a;
    }
    ///////////////////Current_temm////////////////
    ///////////////////MI////////////////


    public function mi_info_add($values)
    {
        $this->Fconnection();
        $today = date("Y-m-d");
        $sql_query = "insert into current_item_info_fainal (item_tb_id,item_id,item_name,qty,unit,sub_group,sub_group_id,`group`,group_id,unit_price,total_value,datei,in_out_status,user_id,pr_id,pq_id,po_id,project_id,licence_id,project_id_exp,vandor_id,`status`,expence_type,gr_id,request_qty,previous_qty,mr_id,mi_id,item_code_inv,main_group_account,district,local_co_id,tmp_table_row_id)
values ('$values[0]','$values[1]','$values[2]','$values[3]','$values[4]','$values[5]','$values[6]','$values[7]','$values[8]','$values[9]','$values[10]',now(),'$values[12]','$values[13]','$values[14]','$values[15]','$values[16]','$values[17]','$values[18]','$values[19]','$values[20]','$values[21]','$values[22]','$values[23]','$values[24]','$values[25]','$values[26]','$values[27]','$values[28]','$values[29]','$values[30]','$values[31]',$values[34])";

        if ($_SESSION['employee_id'] == '02-0047') {
            echo $sql_query;
        }
        $mi_add_sql = mysql_query("$sql_query");
        $mi_asset_code_status = mysql_insert_id();


        // Checking the item type
        $sql_for_item_type = "Select asset_typ from all_item_info where item_id = $values[1]";
        $sql_for_item_type_value = mysql_query("$sql_for_item_type");
//        $sql_for_item_type_value_assoc = mysql_fetch_assoc($sql_for_item_type_value);

        while ($userInfoDetails = mysql_fetch_assoc($sql_for_item_type_value)) {
            $employee_user[] = $userInfoDetails;
        }

        if($employee_user[0]['asset_typ'] == "optical cable" or $employee_user[0]['asset_typ'] == "peices"){

            $mi_asset_code_status_query = "insert into mi_asset_code_status (mi_id, asset_code_assign_status, date,current_item_info_final_id, item_id, item_name, qty, unit ) values(
'$values[27]', 'Asset Not Assigned', now(), $mi_asset_code_status,$values[1],'$values[2]','$values[24]','$values[4]' )";

            $mi_asset_code_status_query_add = mysql_query("$mi_asset_code_status_query");


            $insert_mi_sql = mysql_fetch_array($mi_add_sql);
            return $insert_mi_sql;
        }else {
            $mi_asset_code_status;
        }




    }


    public function mi_info_add_infosarkar($values)
    {
        $this->Fconnection();
        //echo "update infosarker3_serial_fainal set mi_id='$values[27]' where item_id='$values[0]' and status=1";
        $mi_add_sql_update = mysql_query("update infosarker3_serial_fainal set mi_id='$values[27]' where item_id='$values[0]' and status=1");
        $sql = mysql_query("SELECT *  FROM  all_item_info WHERE item_id = '$values[0]'");
        // echo "SELECT *  FROM  all_item_info WHERE item_id = '$value_item_name[$i]'";
        $all_item_data = mysql_fetch_row($sql);

        $today = date("Y-m-d");
        $sql_query = "insert into current_item_info_fainal_infosarkar (item_tb_id,item_id,item_name,qty,unit,sub_group,sub_group_id,`group`,group_id,unit_price,total_value,datei,in_out_status,user_id,pr_id,pq_id,po_id,project_id,licence_id,project_id_exp,vandor_id,`status`,expence_type,gr_id,request_qty,previous_qty,mr_id,mi_id,item_code_inv,main_group_account,district,local_co_id,upazila,union_id,huwaei_id_bom_no,item_description)
values ('$values[0]','$values[1]','$values[2]','$values[3]','$values[4]','$values[5]','$values[6]','$all_item_data[5]','$all_item_data[6]','$values[9]','$values[10]',now(),'$values[12]','$values[13]','$values[14]','$values[15]','$values[16]','$values[17]','$values[18]','$values[19]','$values[20]','$values[21]','$values[22]','$values[23]','$values[24]','$values[25]','$values[26]','$values[27]','$all_item_data[21]','$values[29]','$values[30]','$values[31]',$values[32],$values[33],'$all_item_data[29]','$values[34]')";
//echo $sql_query;
        $mi_add_sql = mysql_query("$sql_query");

        $insert_mi_sql = mysql_fetch_array($mi_add_sql);
        return $insert_mi_sql;
    }


    public function mi_info_add_local_co($values)
    {
        $this->Fconnection();
        $today = date("Y-m-d");
        $sql_query = "insert into current_item_info_fainal_local_co (item_tb_id,item_id,item_name,qty,unit,sub_group,sub_group_id,`group`,group_id,unit_price,total_value,datei,in_out_status,user_id,pr_id,pq_id,po_id,project_id,licence_id,project_id_exp,vandor_id,`status`,expence_type,gr_id,request_qty,previous_qty,mr_id,mi_id,item_code_inv,main_group_account,district,rq_id,upazila_id,union_id,local_co_id)
values ('$values[0]','$values[1]','$values[2]','$values[3]','$values[4]','$values[5]','$values[6]','$values[7]','$values[8]','$values[9]','$values[10]',now(),'$values[12]','$values[13]','$values[14]','$values[15]','$values[16]','$values[17]','$values[18]','$values[19]','$values[20]','$values[21]','$values[22]','$values[23]','$values[24]','$values[25]','$values[26]','$values[27]','$values[28]','$values[29]','$values[30]','$values[31]','$values[32]','$values[33]','$values[34]')";
//echo $sql_query;
        $mi_add_sql = mysql_query("$sql_query");

        $insert_mi_sql = mysql_fetch_array($mi_add_sql);
        return $insert_mi_sql;
    }


    public function mi_info_add_local_co_infosarkar($values)
    {
        $this->Fconnection();
        $today = date("Y-m-d");


        $sql_query = "insert into current_item_info_fainal_local_co_infosarkar (item_tb_id,item_id,item_name,qty,unit,sub_group,sub_group_id,`group`,group_id,unit_price,total_value,datei,in_out_status,user_id,pr_id,pq_id,po_id,project_id,licence_id,project_id_exp,vandor_id,`status`,expence_type,gr_id,request_qty,previous_qty,mr_id,mi_id,item_code_inv,main_group_account,district,rq_id,upazila_id,union_id, local_co_id )
values ('$values[0]','$values[1]','$values[2]','$values[3]','$values[4]','$values[5]','$values[6]','$values[7]','$values[8]','$values[9]','$values[10]','$values[11]','$values[12]','$values[13]','$values[14]','$values[15]','$values[16]','$values[17]','$values[18]','$values[19]','$values[20]','$values[21]','$values[22]','$values[23]','$values[24]','$values[25]','$values[26]','$values[27]','$values[28]','$values[29]','$values[30]','$values[31]','$values[32]','$values[33]','$values[34]')";
//echo $sql_query;
        $mi_add_sql = mysql_query("$sql_query");

        $insert_mi_sql = mysql_fetch_array($mi_add_sql);
        return $insert_mi_sql;
    }


    public function all_item_asset_cdoe_rq($values)
    {
        $this->Fconnection();
        $today = date("Y-m-d");

        for ($j = 0; $j < count($values[3]); ++$j) {
            if ($values[4] == "optical cable") {
                $asset_code = $values[3];

                $insert_statement = "insert into all_item_asset_code_rq(mi_id,rq_id,item_id,item_asset_code,type,cable_start,cable_end,cable_total,status) values (
'$values[0]','$values[1]','$values[2]','$asset_code','$values[4]','$values[5]','$values[6]','$values[7]','$values[8]')";
//

                $mi_add_sql = mysql_query("$insert_statement");

                $select_from_mi_table = "Select * from all_item_asset_code_mi where item_asset_code like '$asset_code' order by id desc limit 1";
                $mi_add_sql_select_from_mi_table = mysql_query("$select_from_mi_table");
                $some_result_all_item_asset_code_mi = mysql_fetch_array($mi_add_sql_select_from_mi_table);

                $new_update = "UPDATE `all_item_asset_code_mi` SET `status` = 1 WHERE  id = $some_result_all_item_asset_code_mi[0]";
                $new_update_query = mysql_query("$new_update");


                if ((int)$some_result_all_item_asset_code_mi[7] != (int)$values[7]) {

                    $new_total = (int)$some_result_all_item_asset_code_mi[7] - (int)$values[7];
                    $new_start = (int)$values[7];
                    $new_end = (int)$some_result_all_item_asset_code_mi[6];

                    // I have to check it tomorrow that will be all;

                    $new_insert_cable = "INSERT INTO all_item_asset_code_mi (item_id, item_asset_code, type, cable_start, cable_end, cable_total, status, mi_id) VALUES ('$some_result_all_item_asset_code_mi[1]', '$some_result_all_item_asset_code_mi[2]', '$some_result_all_item_asset_code_mi[3]', $new_start, $new_end, $new_total, 0, '$some_result_all_item_asset_code_mi[9]')";

                    $new_insert_cable_query = mysql_query("$new_insert_cable");
                }


            } else {
                $asset_code = $values[3][$j];

                $insert_statement = "insert into all_item_asset_code_rq(mi_id,rq_id,item_id,item_asset_code,type,cable_start,cable_end,cable_total,status) values (
'$values[0]','$values[1]','$values[2]','$asset_code','$values[4]','$values[5]','$values[6]','$values[7]','$values[8]')";
//

                $mi_add_sql = mysql_query("$insert_statement");


                $select_from_mi_table = "Select * from all_item_asset_code_mi where item_asset_code like '$asset_code' order by id desc limit 1";
                $mi_add_sql_select_from_mi_table = mysql_query("$select_from_mi_table");
                $some_result_all_item_asset_code_mi = mysql_fetch_array($mi_add_sql_select_from_mi_table);

                $new_update = "UPDATE `all_item_asset_code_mi` SET `status` = 1 WHERE  id = $some_result_all_item_asset_code_mi[0]";
                $new_update_query = mysql_query("$new_update");


            }


//
            $insert_mi_sql = mysql_fetch_array($mi_add_sql);
        }


//        $sql_query = "insert into current_item_info_fainal_local_co_infosarkar (item_tb_id,item_id,item_name,qty,unit,sub_group,sub_group_id,`group`,group_id,unit_price,total_value,datei,in_out_status,user_id,pr_id,pq_id,po_id,project_id,licence_id,project_id_exp,vandor_id,`status`,expence_type,gr_id,request_qty,previous_qty,mr_id,mi_id,item_code_inv,main_group_account,district,rq_id,upazila_id,union_id, local_co_id )
//values ('$values[0]','$values[1]','$values[2]','$values[3]','$values[4]','$values[5]','$values[6]','$values[7]','$values[8]','$values[9]','$values[10]','$values[11]','$values[12]','$values[13]','$values[14]','$values[15]','$values[16]','$values[17]','$values[18]','$values[19]','$values[20]','$values[21]','$values[22]','$values[23]','$values[24]','$values[25]','$values[26]','$values[27]','$values[28]','$values[29]','$values[30]','$values[31]','$values[32]','$values[33]','$values[34]')";
////echo $sql_query;

        return $insert_mi_sql;
    }


    public function all_item_asset_cdoe_usage($values)
    {
        $this->Fconnection();
        $today = date("Y-m-d");

        for ($j = 0; $j < count($values[4]); ++$j) {
            if ($values[5] == "optical cable") {
                $asset_code = $values[4][$j];

                $insert_statement = "insert into all_item_asset_code_usage(mi_id,rq_id, usage_id, item_id,item_asset_code,type,cable_id, cable_start,cable_end,cable_total,status) values (
'$values[0]','$values[1]','$values[2]','$values[3]','$asset_code','$values[5]','$values[6]','$values[7]','$values[8]','$values[9]','$values[10]')";
//

                $mi_add_sql = mysql_query("$insert_statement");


                $select_from_mi_table = "Select * from all_item_asset_code_rq where item_asset_code like '$asset_code' and rq_id like '$values[1]' order by id desc limit 1";
                $mi_add_sql_select_from_mi_table = mysql_query("$select_from_mi_table");
                $some_result_all_item_asset_code_mi = mysql_fetch_array($mi_add_sql_select_from_mi_table);

                $new_update = "UPDATE `all_item_asset_code_rq` SET `status` = 1 WHERE  id = $some_result_all_item_asset_code_mi[0]";
                $new_update_query = mysql_query("$new_update");


                if ((int)$some_result_all_item_asset_code_mi[9] != (int)$values[9]) {

                    $new_total = (int)$some_result_all_item_asset_code_mi[9] - (int)$values[9];
//                    $new_start = (int) $values[9];
                    $new_start = (int)$values[9] + (int)$some_result_all_item_asset_code_mi[7];
//                    $new_end = (int) $some_result_all_item_asset_code_mi[9];                    $new_start = (int) $values[9] + (int) $some_result_all_item_asset_code_mi[7];
                    $new_end = (int)$some_result_all_item_asset_code_mi[8];

                    // I have to check it tomorrow that will be all;

//                    $new_insert_cable = "INSERT INTO all_item_asset_code_mi (item_id, item_asset_code, type, cable_start, cable_end, cable_total, status, mi_id) VALUES ('$some_result_all_item_asset_code_mi[1]', '$some_result_all_item_asset_code_mi[2]', '$some_result_all_item_asset_code_mi[3]', $new_start, $new_end, $new_total, 0, '$some_result_all_item_asset_code_mi[9]')";


                    $new_insert_cable = "insert into all_item_asset_code_rq(mi_id,rq_id,item_id,item_asset_code,type,cable_start,cable_end,cable_total,status) values (
'$some_result_all_item_asset_code_mi[1]','$some_result_all_item_asset_code_mi[2]','$some_result_all_item_asset_code_mi[3]','$some_result_all_item_asset_code_mi[4]','$some_result_all_item_asset_code_mi[5]','$new_start','$new_end','$new_total',0)";

                    $new_insert_cable_query = mysql_query("$new_insert_cable");
                }


            } else {
                $asset_code = $values[4][$j];

//                $insert_statement="insert into all_item_asset_code_usage(mi_id,rq_id,item_id,item_asset_code,type,cable_start,cable_end,cable_total,status) values (
//'$values[0]','$values[1]','$values[2]','$asset_code','$values[4]','$values[5]','$values[6]','$values[7]','$values[8]')";

                $insert_statement = "insert into all_item_asset_code_usage(mi_id,rq_id, usage_id, item_id,item_asset_code,type,cable_id, cable_start,cable_end,cable_total,status) values (
'$values[0]','$values[1]','$values[2]','$values[3]','$asset_code','$values[5]','$values[6]','$values[7]','$values[8]','$values[9]','$values[10]')";
//

                $mi_add_sql = mysql_query("$insert_statement");


                $select_from_mi_table = "Select * from all_item_asset_code_rq where item_asset_code like '$asset_code' and rq_id like '$values[1]' order by id desc limit 1";
                $mi_add_sql_select_from_mi_table = mysql_query("$select_from_mi_table");
                $some_result_all_item_asset_code_mi = mysql_fetch_array($mi_add_sql_select_from_mi_table);

                $new_update = "UPDATE `all_item_asset_code_rq` SET `status` = 1 WHERE  id = $some_result_all_item_asset_code_mi[0]";
                $new_update_query = mysql_query("$new_update");


            }


//
            $insert_mi_sql = mysql_fetch_array($mi_add_sql);
        }


//        $sql_query = "insert into current_item_info_fainal_local_co_infosarkar (item_tb_id,item_id,item_name,qty,unit,sub_group,sub_group_id,`group`,group_id,unit_price,total_value,datei,in_out_status,user_id,pr_id,pq_id,po_id,project_id,licence_id,project_id_exp,vandor_id,`status`,expence_type,gr_id,request_qty,previous_qty,mr_id,mi_id,item_code_inv,main_group_account,district,rq_id,upazila_id,union_id, local_co_id )
//values ('$values[0]','$values[1]','$values[2]','$values[3]','$values[4]','$values[5]','$values[6]','$values[7]','$values[8]','$values[9]','$values[10]','$values[11]','$values[12]','$values[13]','$values[14]','$values[15]','$values[16]','$values[17]','$values[18]','$values[19]','$values[20]','$values[21]','$values[22]','$values[23]','$values[24]','$values[25]','$values[26]','$values[27]','$values[28]','$values[29]','$values[30]','$values[31]','$values[32]','$values[33]','$values[34]')";
////echo $sql_query;

        return $insert_mi_sql;
    }


// show all inventory item for local co
    public function inventory_update_info_local_co($statement, $start_from, $num_rec_per_page, $district)
    {
        $this->Fconnection();

        //$sql1="select * from current_item_info_fainal where current_item_info_fainal.id<>0 and current_item_info_fainal.id in (select max(id) from current_item_info_fainal group by item_id)  $statement order by item_name";
        //select tt.* from current_item_info_fainal_local_co tt INNER JOIN (SELECT item_tb_id, MAX(id) AS id1 FROM current_item_info_fainal_local_co GROUP BY item_tb_id) cciif ON tt.item_tb_id = cciif.item_tb_id AND tt.id = cciif.id1 and tt.district=$district   order by tt.item_tb_id desc limit 100
        $sql1 = "select * from current_item_info_fainal_local_co tt INNER JOIN (SELECT item_tb_id, MAX(id) AS id1 FROM current_item_info_fainal_local_co GROUP BY item_tb_id ,district) cciif ON tt.item_tb_id = cciif.item_tb_id AND tt.id = cciif.id1 and tt.district IN($district) and tt.qty!=''   order by tt.item_tb_id desc  ";
        //echo $sql1;
        $select_all_item_sql1 = mysql_query("$sql1");

        return $select_all_item_sql1;
    }

    public function inventory_update_info_local_co_infosarkar($statement, $start_from, $num_rec_per_page, $district_id)
    {
        $this->Fconnection();

        //$sql1="select * from current_item_info_fainal where current_item_info_fainal.id<>0 and current_item_info_fainal.id in (select max(id) from current_item_info_fainal group by item_id)  $statement order by item_name";
        $sql1 = "select tt.* from current_item_info_fainal_local_co_infosarkar tt INNER JOIN (SELECT item_tb_id, MAX(id) AS id1 FROM current_item_info_fainal_local_co_infosarkar GROUP BY item_tb_id) cciif ON tt.item_tb_id = cciif.item_tb_id AND tt.id = cciif.id1 and tt.district IN($district_id) and tt.qty!=''  order by tt.item_tb_id desc limit 100 ";
        //  echo $sql1;
        $select_all_item_sql1 = mysql_query("$sql1");

        return $select_all_item_sql1;
    }


    public function inventory_update_info_local_co_count()
    {
        $this->Fconnection();

        //$sql1="select * from current_item_info_fainal where current_item_info_fainal.id<>0 and current_item_info_fainal.id in (select max(id) from current_item_info_fainal group by item_id)  $statement order by item_name";
        $sql1 = "select tt.* from current_item_info_fainal_local_co tt INNER JOIN (SELECT item_tb_id, MAX(id) AS id1 FROM current_item_info_fainal_local_co GROUP BY item_tb_id) cciif ON tt.item_tb_id = cciif.item_tb_id AND tt.id = cciif.id1    order by id desc";
        // echo $sql1;
        $select_all_item_sql1 = mysql_query("$sql1");

        return $select_all_item_sql1;
    }

    public function inventory_info_all($statement)
    {
        $this->Fconnection();

        //$sql1="select * from current_item_info_fainal where current_item_info_fainal.id<>0 and current_item_info_fainal.id in (select max(id) from current_item_info_fainal group by item_id)  $statement order by item_name";
        $sql1 = "select * from current_item_info_fainal where current_item_info_fainal.id<>0  $statement order by id desc,item_name asc limit 100";
        // echo $sql1;

        $select_all_item_sql1 = mysql_query("$sql1");
        while ($item_list_info1 = mysql_fetch_array($select_all_item_sql1)) {
            $list_item1[] = $item_list_info1;
        }
        return $list_item1;

    }


    public function inventory_info_all_local($statement, $limit)
    {
        $this->Fconnection();

        //$sql1="select * from current_item_info_fainal where current_item_info_fainal.id<>0 and current_item_info_fainal.id in (select max(id) from current_item_info_fainal group by item_id)  $statement order by item_name";
        $sql1 = "select * from current_item_info_fainal_local_co where current_item_info_fainal_local_co.id<>0  $statement order by id desc,item_name asc $limit";
        //  echo $sql1;

        $select_all_item_sql1 = mysql_query("$sql1");
        while ($item_list_info1 = mysql_fetch_array($select_all_item_sql1)) {
            $list_item1[] = $item_list_info1;
        }
        return $list_item1;

    }


    public function inventory_info_all_infosarkar($statement, $start_from, $num_rec_per_page, $from_date, $to_date)
    {
        $this->Fconnection();

        //$sql1="select * from current_item_info_fainal where current_item_info_fainal.id<>0 and current_item_info_fainal.id in (select max(id) from current_item_info_fainal group by item_id)  $statement order by item_name";
        $sql1 = "SELECT `item_tb_id`, `item_id`, `item_name`, `qty`, `unit`, `sub_group`, `sub_group_id`, `group`, `group_id`, `main_group_account`, `main_group_account_id`, `moving_type`, `last_purchase`, `unit_price`, `total_value`, `fmoving_critical_status`, `datei`, `in_out_status`, `user_id`, `pr_id`, `pq_id`, `po_id`, `mr_id`, `project_id`, `licence_id`, `project_id_exp`, `vandor_id`, `status`, `issue2_user_id`, `issue_date`, `expence_type`, `scr_id`, `invtrack_id`, `gr_id`, `mi_id`, `request_qty`, `previous_qty`, `item_code_inv`, `ref_no`, `lc_no`, `district`, `flag_infosarkar_product`, `note`, `local_co_id`,rq_id,upazila,union_id FROM  current_item_info_fainal_infosarkar where current_item_info_fainal_infosarkar.item_tb_id<>0 ";
        $sql2 = "";
        if (!empty($from_date) || !empty($to_date)) {
            if (!empty($from_date) && empty($to_date)) {
                $sql2 = "and current_item_info_fainal_infosarkar.datei >= '" . $from_date . ' 00:00:00' . "' ";
            } elseif (empty($from_date) && !empty($to_date)) {
                $sql2 = "and current_item_info_fainal_infosarkar.datei <= '" . $to_date . ' 23:59:59' . "' ";
            } else {
                $sql2 = "and current_item_info_fainal_infosarkar.datei >= '" . $from_date . ' 00:00:00' . "' and current_item_info_fainal_infosarkar.datei <= '" . $to_date . ' 23:59:59' . "' ";
            }
        }
        $sql3 = "and $statement order by id desc,item_name asc LIMIT $start_from, $num_rec_per_page";
        $sql = $sql1 . $sql2 . $sql3;

        $select_all_item_sql1 = mysql_query("$sql");
        // echo $sql1;

        return $select_all_item_sql1;

    }


    public function inventory_info_all_infosarkar_local_co($statement, $start_from, $num_rec_per_page)
    {
        $this->Fconnection();

        //$sql1="select * from current_item_info_fainal where current_item_info_fainal.id<>0 and current_item_info_fainal.id in (select max(id) from current_item_info_fainal group by item_id)  $statement order by item_name";
        $sql1 = "SELECT
  `item_tb_id`, `item_id`, `item_name`, `qty`, `unit`, `sub_group`, `sub_group_id`, `group`, `group_id`, `main_group_account`, `main_group_account_id`, `moving_type`, `last_purchase`, `unit_price`, `total_value`, `fmoving_critical_status`, `datei`, `in_out_status`, `user_id`, `pr_id`, `pq_id`, `po_id`, `mr_id`, `project_id`, `licence_id`, `project_id_exp`, `vandor_id`, `status`, `issue2_user_id`, `issue_date`, `expence_type`, `scr_id`, `invtrack_id`, `gr_id`, `mi_id`, `request_qty`, `previous_qty`, `item_code_inv`, `ref_no`, `lc_no`, `district`,  `note`, `local_co_id`,rq_id,upazila_id,union_id
  FROM  current_item_info_fainal_local_co_infosarkar where current_item_info_fainal_local_co_infosarkar.item_tb_id<>0 and $statement order by item_tb_id desc LIMIT $start_from, $num_rec_per_page";
        $select_all_item_sql1 = mysql_query("$sql1");
        //echo $sql1;

        return $select_all_item_sql1;

    }



    ///////////////////MI////////////////


    ////////////////////Project ////////////////////////////////
    public function project_info($val)
    {
        $this->Fconnection();

        $sql = "select * from project_info where project_id='$val'";
        //echo "$sql";
        $project_info = mysql_query("$sql");
        $project_info1 = mysql_fetch_array($project_info);
        return $project_info1;
    }
    ////////////////////Project ////////////////////////////////


//add multiple info start    adba


    public function pr_ifram_temp_item_info_adba($number, $value_sub_group, $value_item_name, $value_reason_of_problem, $value_ordered_quantity, $pr_id, $vat_value, $table_tmp_item_info_temp)
    {
        $this->Fconnection();


//echo $value_item_name[0];

        for ($i = 0; $i < $number; $i++) {
            $reason_ = mysql_real_escape_string($value_reason_of_problem[$i]);
            // echo "INSERT INTO tmp_item_info_temp1 (item_id,item_name,description,ordered_quantity,pr_id,vat,date) VALUES ('$value_item_name[$i]','$value_item_name[$i]','$value_reason_of_problem[$i]','$value_ordered_quantity[$i]','$pr_id_get',$vat_value,now())";
            $sql = mysql_query("SELECT *  FROM  all_item_info WHERE item_id = '$value_item_name[$i]'");
            // echo "SELECT *  FROM  all_item_info WHERE $where_c = '$val1'";
            $unit_val = mysql_fetch_row($sql);


            $sqll = "INSERT INTO $table_tmp_item_info_temp (item_id,item_name,description,ordered_quantity,pr_id,vat,date,unit) VALUES ('$value_item_name[$i]','$value_item_name[$i]','$reason_','$value_ordered_quantity[$i]','$pr_id',$vat_value,now(),'$unit_val[9]')";

            //echo $sqll;
            $result1 = mysql_query($sqll);

        }


        return $result1;
    }

    /**
     * @param $number
     * @param $mr_id
     * @param $value_sub_group
     * @param $value_item_name
     * @param $value_reason_of_problem
     * @param $value_ordered_quantity
     * @param $vat
     * @param $table_tmp_item_info
     * @return resource
     */

    /*


    /**

 public function mr_ifram_temp_item_info_($serv)
 {
    $this->Fconnection();
    //$insert_item="INSERT INTO tmp_item_info(item_name,description,ordered_quantity,unit,price_per_unit,total_value,pr_id,vat,date)VALUES('$serv[0]','$serv[1]','$serv[2]','$serv[3]','$serv[4]','$serv[5]','$serv[6]','$serv[7]',now())";

    $insert_item="INSERT INTO tmp_item_info_mr(item_name,description,ordered_quantity,unit,mr_id,vat,date,item_id)VALUES('$serv[0]','$serv[1]','$serv[2]','$serv[3]','$serv[4]','$serv[5]',now(),'$serv[0]')";
    //echo $insert_item;
     $result_insert=mysql_query($insert_item);
     $mr_cash_ifram_temp_item_info= mysql_fetch_array($result_insert);

 }

*/


    public function mr_ifram_temp_item_info_adba($number, $mr_id, $value_sub_group, $value_item_name, $value_reason_of_problem, $value_ordered_quantity, $vat, $table_tmp_item_info)
    {
        $this->Fconnection();


//echo $value_item_name[0];
        if ($number > 0) {
            for ($i = 0; $i < $number; $i++) {

                $sql = mysql_query("SELECT *  FROM  all_item_info WHERE item_id = '$value_item_name[$i]'");
                // echo "SELECT *  FROM  all_item_info WHERE item_id = '$value_item_name[$i]'";
                $unit_val = mysql_fetch_row($sql);

                $sqll = "INSERT INTO $table_tmp_item_info (item_tb_id,item_id,item_name,description,ordered_quantity,date,mr_id,vat,unit,sl,huwaei_id_bom_no) VALUES (null, '$value_item_name[$i]','$value_item_name[$i]','$value_reason_of_problem[$i]','$value_ordered_quantity[$i]',now(),'$mr_id',$vat,'$unit_val[9]','$unit_val[30]','$unit_val[29]')";

                //  echo $sqll;
                $result1 = mysql_query($sqll);

            }

        }

        return $result1;
    }

    public function mr_info1_edit($values)
    {
        $this->Fconnection();
        $today = date("Y-m-d");
        $pr0_edit_info_sql1 = "UPDATE $values[22] SET `mr_type`=$values[1],`mr_date`='$values[2]',`mr_by`='$values[3]',`mr_porpuse`='$values[4]',`delivery_instruction`='$values[8]',`remarks`='$values[9]',`license_id`='$values[10]',`co_id`='$values[11]',`mr_verify_by`='$values[16]',`mr_verify_date`='$values[16]',`mr_approve_by`='$values[16]',`mr_approval_date`='$values[16]',`uploaded_file`='$values[12]',`project_id`='$values[12]',`project_id_new`='$values[13]',`project_id_new_for`='$values[14]',`exp_description`='$values[15]',`expected_date`='$values[16]',`employee_to`='$values[17]',district='$values[18]',`upazilla_id`='$values[19]',`union_id`='$values[20]',`local_co_id`='$values[21]',mi_page_status=$values[24] WHERE mr_id ='$values[0]' and mr_id !=''";


        // echo $pr0_edit_info_sql1;
        $pr0_edit_info = mysql_query("$pr0_edit_info_sql1");

        $pr0_edit_info_sql = mysql_fetch_array("$pr0_edit_info");
        return $pr0_edit_info_sql;
    }




    //add multiple info end


//code 17_december start here          adba

    public function show_item_group_in_select()
    {
        $this->Fconnection();


        $sql = mysql_query("select group_name,group_id from all_item_info group by group_id order by group_name");
        return $sql;
    }

    public function show_item_group_in_select_infosarkar()
    {
        $this->Fconnection();
//select current_item_info_fainal_infosarkar.group,group_id from current_item_info_fainal_infosarkar where current_item_info_fainal_infosarkar.flag_infosarkar_product=1 group by group_id order by current_item_info_fainal_infosarkar.group
        //
        $sql = mysql_query("select group_name,group_id from all_item_info WHERE flag_info =1 group by group_id order by group_name");
        return $sql;
    }

    public function show_item_name_with_group_id_in_select($var)
    {
        $this->Fconnection();
        $sql = mysql_query("SELECT item_tb_id,item_name,group_id,group  FROM  all_item_info WHERE group_id = '$var'");
        // echo "SELECT item_tb_id,item_name,group_id,group  FROM  all_item_info WHERE group_id = '$var'";
        $val = mysql_fetch_row($sql);
        return $val;
    }


    public function single_item_info_details($val1, $where_c)
    {
        $this->Fconnection();


        $sql = mysql_query("SELECT *  FROM  all_item_info WHERE item_id = '$val1'");
        // echo "SELECT *  FROM  all_item_info WHERE $where_c = '$val1'";
        $val = mysql_fetch_row($sql);
        return $val;
    }

    public function get_district_name($val1, $duu_table)
    {
        $this->Fconnection();


        $sql = mysql_query("SELECT * FROM $duu_table WHERE dist_id = '$val1'");
        // echo "SELECT * FROM $duu_table WHERE dist_id = '$val1'";
        $val = mysql_fetch_row($sql);
        return $val;
    }

    /*  public function get_upazila_name($val1)
    {
        $this->Fconnection();


$sql=mysql_query("SELECT * FROM `district_name_scm` WHERE id = '$val1'");
        // echo "SELECT *  FROM  all_item_info WHERE $where_c = '$val1'";
$val=mysql_fetch_row($sql);
    return  $val;
    }

     public function get_union_name($val1)
    {
        $this->Fconnection();


$sql=mysql_query("SELECT * FROM `district_name_scm` WHERE id = '$val1'");
        // echo "SELECT *  FROM  all_item_info WHERE $where_c = '$val1'";
$val=mysql_fetch_row($sql);
    return  $val;
    }*/

    public function get_Expansion_Id()
    {
        $this->Fconnection();


        $sql = mysql_query("
SELECT
    project_tb_id,
    project_id,
    project_name 
FROM
    `project_info_new` 
order by
    project_name
          ");
        return $sql;
    }

    public function get_project_info_new_expantion()
    {
        $this->Fconnection();


        $sql = mysql_query("SELECT project_tb_id,project_id,project_name FROM `project_info_new_expantion`");
        return $sql;
    }


    public function get_License_Id()
    {
        $this->Fconnection();


        $sql = mysql_query("SELECT license_tb_id,license_id,license_name FROM `license_info`");
        return $sql;
    }

    public function get_Zone_Id()
    {
        $this->Fconnection();


        $sql = mysql_query("SELECT co_tb_id,co_id,co_name FROM `co_info` order by co_name");
        return $sql;
    }

    public function get_Project_Id()
    {
        $this->Fconnection();


        $sql = mysql_query("SELECT project_tb_id,project_id,project_name FROM `project_info` where `status`!=3 order by project_name");
        return $sql;
    }

    public function get_District_Id()
    {
        $this->Fconnection();
        $sql = mysql_query("SELECT * FROM `district_name` ORDER BY district_name");
        // echo "SELECT * FROM `district_name`";
        return $sql;
    }

    public function get_District_Id_infosarker()
    {
        $this->Fconnection();
        $sql = mysql_query("SELECT * FROM `district_name` where (dist_id < 33) or (dist_id =62) order by district_name");
        // echo "SELECT * FROM `district_name`";
        return $sql;
    }


    public function get_Scm_Person_Id()
    {
        $this->Fconnection();


        $sql = mysql_query("SELECT employee_id,full_name FROM admin_user_info where user_type=11 and status =1 order by full_name");
        return $sql;
    }

    public function get_It_Person_Id()
    {
        $this->Fconnection();


        $sql = mysql_query("SELECT employee_id,full_name FROM admin_user_info where employee_id='02-0323' or employee_id='02-0458' or employee_id='02-0007' order by full_name");
        return $sql;
    }

    public function get_Pq_Client_Id()
    {
        $this->Fconnection();


        $sql = mysql_query("SELECT vendor_tb_id,name FROM vendor_info order by name");
        return $sql;
    }

//code 17_december end here

//code 01_jan_2017 start here          adba

    public function it_user_id_fun()
    {
        $this->Fconnection();

//$sSqlWrk = "SELECT employee_id,full_name FROM admin_user_info where employee_id='02-0323' or employee_id='02-0458' or employee_id='02-0007' order by full_name";


        $sql = mysql_query("SELECT employee_id,full_name FROM admin_user_info where employee_id='02-0323' or employee_id='02-0458' or employee_id='02-0007' order by full_name");
        return $sql;
    }


    public function scm_user_id_fun()
    {
        $this->Fconnection();

//$sSqlWrk = "SELECT employee_id,full_name FROM admin_user_info where employee_id='02-0323' or employee_id='02-0458' or employee_id='02-0007' order by full_name";


        $sql = mysql_query("SELECT employee_id,full_name FROM admin_user_info where employee_id='01-0001' or employee_id='02-0003' or employee_id='01-0002' or employee_id='02-0323' or employee_id='02-0473' or employee_id='02-0458'  order by full_name");
        return $sql;
    }

//code 01_jan_2017 end here

    public function usage_from_rq($values)
    {
        $this->Fconnection();
        $today = date("Y-m-d");
        $sql = mysql_query("SELECT *  FROM  all_item_info WHERE item_id = '$values[0]'");
        // echo "SELECT *  FROM  all_item_info WHERE item_id = '$value_item_name[$i]'";
        $unit_val = mysql_fetch_row($sql);

        $sql_query = "insert into tbl_report_usage_02_01_2017 (value_item_name,item_name,uom,group_name,value_sub_group,usage_date,employee_id,project_id_name,client_name,qty,mi_id,district_name,rq_id,upazila_id,union_id,local_co_id,scr,start_reading_name,end_reading_name,usage_id,status_infosarkar,serial_number_name,cable_id_name,use_location_name,work_done_by, current_date_time,spr_id, ccr_id, ring,from_location, to_site_id, value_reason_of_problem, save_submit_status ,flag,mr_id,fh_vendor_name,due_value,rq_value,ref_id,segment_id)
values ('$values[0]','$values[1]','$unit_val[9]','$unit_val[5]','$unit_val[6]','$values[19]','$values[6]','$values[7]','$values[8]','$values[9]','$values[10]','$values[11]','$values[12]','$values[13]','$values[14]','$values[15]','$values[16]','$values[17]','$values[18]','$values[20]',$values[21],'$values[22]','$values[23]' ,'$values[24]' ,'$values[25]' , now(),'$values[26]','$values[27]','$values[28]' ,'$values[29]' ,'$values[30]' ,'$values[31]' ,'$values[32]',0,'$values[33]','$values[34]','$values[35]',$values[36],'$values[37]','$values[42]')";
        if ($_SESSION['employee_id'] == '02-0629') {
            echo $sql_query;
        }

        $mi_add_sql = mysql_query("$sql_query");

        $insert_mi_sql = mysql_fetch_array($mi_add_sql);
        return $insert_mi_sql;
    }


    public function usage_from_rq_infosarkar($values)
    {

        $this->Fconnection();
        $today = date("Y-m-d");
        $now = date('Y-m-d H:i:s');
        $sql = mysql_query("SELECT *  FROM  all_item_info WHERE item_id = '$values[item_tb_id]'");
        // echo "SELECT *  FROM  all_item_info WHERE item_id = '$value_item_name[$i]'";
        $unit_val = mysql_fetch_row($sql);

        $sql_query = "insert into tbl_report_usage_02_01_2017 (value_item_name,item_name,uom,group_name,value_sub_group,usage_date,employee_id,project_id_name,client_name,qty,mi_id,district_name,rq_id,upazila_id,union_id,local_co_id,scr,start_reading_name,end_reading_name,usage_id,status_infosarkar,serial_number_name,cable_id_name,use_location_name,work_done_by,current_date_time,spr_id,ccr_id,ring,from_location,to_site_id,value_reason_of_problem,save_submit_status,flag,mr_id,fh_vendor_name,due_value,rq_value,ref_id,from_gps_lat,to_gps_lat,from_gps_long,to_gps_long,segment_id)
values ('$values[item_tb_id]','$values[item_name]','$unit_val[9]','$unit_val[5]','$unit_val[6]','$values[usage_date]','$values[created_user]','$values[project_id]','$values[client_name]','$values[qty]','$values[mi_id]','$values[district_name]','$values[rq_id]','$values[upazila]','$values[union]','$values[local_co_id]','$values[scr_id]','$values[start_reading]','$values[end_reading]','$values[usage_id]','$values[status_infosarkar]','$values[sl_no]','$values[cable_id]','$values[use_location]','$values[work_done_by]','$now','$values[spr_id]','$values[ccr_id]','$values[ring_id]','$values[from_location]','$values[to_location]','$values[remarks]','$values[submit_status]',0,'$values[mr_id]',NULL,'$values[due]','$values[rq_quantity]',NULL,'$values[from_gps_lat]','$values[to_gps_lat]','$values[from_gps_long]','$values[to_gps_long]','$values[segment_id]')";
        //if($_SESSION['employee_id']=='02-0047'){echo $sql_query;}

        $mi_add_sql = mysql_query("$sql_query");

        $insert_mi_sql = mysql_fetch_array($mi_add_sql);
        return $mi_add_sql;
    }

    public function usage_from_rq_fttx($values)
    {
        $this->Fconnection();
        $today = date("Y-m-d");
        $sql = mysql_query("SELECT *  FROM  all_item_info WHERE item_id = '$values[0]'");
        // echo "SELECT *  FROM  all_item_info WHERE item_id = '$value_item_name[$i]'";
        $unit_val = mysql_fetch_row($sql);

        $sql_query = "insert into tbl_report_usage_02_01_2017 (value_item_name,item_name,uom,group_name,value_sub_group,usage_date,employee_id,project_id_name,client_name,qty,mi_id,district_name,rq_id,upazila_id,union_id,local_co_id,scr,start_reading_name,end_reading_name,usage_id,status_infosarkar,serial_number_name,cable_id_name,use_location_name,work_done_by, current_date_time,spr_id, ccr_id, ring,from_location, to_site_id, value_reason_of_problem, save_submit_status ,flag,mr_id,fh_vendor_name,due_value,rq_value,ref_id)
    values ('$values[0]','$values[1]','$values[2]','$unit_val[5]','$unit_val[6]','$values[19]','$values[6]','$values[7]','$values[8]','$values[9]','$values[10]','$values[11]','$values[12]','$values[13]','$values[14]','$values[15]','$values[16]','$values[17]','$values[18]','$values[20]',$values[21],'$values[22]','$values[23]' ,'$values[24]' ,'$values[25]' , now(),'$values[26]','$values[27]','$values[28]' ,'$values[29]' ,'$values[30]' ,'$values[31]' ,'$values[32]',0,'$values[33]','$values[34]','$values[35]',$values[36],'$values[37]')";


        $mi_add_sql = mysql_query("$sql_query");

        $last_row = mysql_insert_id();

        $sql_query2 = "insert into tbl_fttx_usage_address_info (FDH_No,Cluster_No,Mother_House_No,Road_No,Subhouse,FAT_Box,mFAT_Box,tbl_usage_row_id)
    values ('$values[38]','$values[39]','$values[40]','$values[41]','$values[42]','$values[43]','$values[44]','$last_row')";
        if ($_SESSION['employee_id'] == '02-0629') {
            echo $sql_query2;
        }
        $mi_add_sql = mysql_query("$sql_query2");


        $insert_mi_sql = mysql_fetch_array($mi_add_sql);
        return $insert_mi_sql;
    }


    public function usage_report($number, $usage_dateeeeeee, $value_sub_group, $value_item_name, $serial_number_name, $use_location_name, $district_name, $project_id_name, $client_name_name, $scr_id, $cable_id_name, $start_reading_name, $end_reading_name, $value_ordered_quantity, $value_reason_of_problem, $table_name, $upazila_name, $union_name, $status, $from_location_name, $ccr_id, $spr_id, $to_location_name, $ring_num)
    {
        $this->Fconnection();

        if ($number > 0) {
            for ($i = 0; $i < $number; $i++) {


                if ($union_name[$i] != '') {
                    $local_co_no = 'un' . $union_name[$i];

                } elseif ($district_name[$i] && $upazila_name[$i] != '') {
                    $local_co_no = 'up' . $upazila_name[$i];

                } else {

                    $local_co_no = 'dis' . $district_name[$i];

                }

                $employee_id = $_SESSION['employee_id'];
                $today_cur_d_t = date("Y-m-d H:i:s");
                $sql = mysql_query("SELECT *  FROM  all_item_info WHERE item_id = '$value_item_name[$i]'");
                // echo "SELECT *  FROM  all_item_info WHERE item_id = '$value_item_name[$i]'";
                $unit_val = mysql_fetch_row($sql);


                $sqll = "INSERT INTO $table_name (id,usage_date,value_sub_group,value_item_name,serial_number_name,use_location_name,district_name,project_id_name,client_name,scr,cable_id_name,start_reading_name,end_reading_name,qty,value_reason_of_problem,upazila_id,union_id,save_submit_status,from_location,local_co_id,ccr_id,spr_id,to_site_id,ring,uom,employee_id,current_date_time) VALUES (NULL,'$usage_dateeeeeee[$i]','$value_sub_group[$i]','$value_item_name[$i]','$serial_number_name[$i]','$use_location_name[$i]','$district_name[$i]','$project_id_name[$i]','$client_name_name[$i]','$scr_id[$i]','$cable_id_name[$i]','$start_reading_name[$i]','$end_reading_name[$i]','$value_ordered_quantity[$i]','$value_reason_of_problem[$i]','$upazila_name[$i]','$union_name[$i]',$status,'$from_location_name[$i]','$local_co_no','$ccr_id[$i]','$spr_id[$i]','$to_location_name[$i]','$ring_num[$i]','$unit_val[9]','$employee_id','$today_cur_d_t')";

                // echo $sqll;
                $result1 = mysql_query($sqll);

            }

        }

        return $result1;
    }

    public function Single_item_add_in_usage_report($data, $table_name)
    {
        $this->Fconnection();


        $sqll = "INSERT INTO $table_name (id,usage_date,value_sub_group,value_item_name,serial_number_name,use_location_name,district_name,project_id_name,client_name,scr,cable_id_name,start_reading_name,end_reading_name,qty,value_reason_of_problem,save_submit_status) VALUES (NULL,'$data[1]','$data[2]','$data[3]','$data[4]','$data[5]','$data[6]','$data[7]','$data[8]',$data[9],'$data[10]','$data[11]','$data[12]','$data[13]','$data[14]',1)";

        //echo $sqll;
        $result1 = mysql_query($sqll);


        return $result1;
    }

    public function update_usage_report($number, $usage_dateeeeeee, $value_sub_group, $value_item_name, $serial_number_name, $use_location_name, $district_name, $project_id_name, $client_name_name, $scr_id, $cable_id_name, $start_reading_name, $end_reading_name, $value_ordered_quantity, $value_reason_of_problem, $row_id_for_update_db, $set_status)
    {
        $this->Fconnection();


        $sqll = "update tbl_report_usage_02_01_2017_temp set usage_date='$usage_dateeeeeee',value_sub_group='$value_sub_group',value_item_name='$value_item_name',serial_number_name='$serial_number_name',use_location_name='$use_location_name',district_name='$district_name',project_id_name='$project_id_name',client_name='$client_name_name',scr='$scr_id',cable_id_name='$cable_id_name',start_reading_name='$start_reading_name',end_reading_name='$end_reading_name',qty='$value_ordered_quantity',value_reason_of_problem='$value_reason_of_problem',save_submit_status=$set_status where id=$row_id_for_update_db";

        //echo $sqll;
        $result1 = mysql_query($sqll);


        return $result1;
    }


    public function get_personal_temp_PR($var)
    {
        $this->Fconnection();

//SELECT * FROM `scm_approval_tree_temp` WHERE pr_by = '$var'

        $sql = mysql_query("SELECT scm_approval_tree_temp.pr_id,pr_info1_temp.project_id,scm_approval_tree_temp.pr_by FROM `scm_approval_tree_temp`,pr_info1_temp WHERE scm_approval_tree_temp.pr_id=pr_info1_temp.pr_id
AND scm_approval_tree_temp.pr_by ='$var'");

        return $sql;
    }


    public function get_Total_Mr_By_Single_user($var)
    {
        $this->Fconnection();

//$sSqlWrk = "SELECT employee_id,full_name FROM admin_user_info where employee_id='02-0323' or employee_id='02-0458' or employee_id='02-0007' order by full_name";


        $sql = mysql_query("SELECT * FROM `scm_approval_tree_inventory` WHERE mr_by = '$var'");
        // echo "SELECT * FROM `scm_approval_tree_inventory` WHERE mr_by = '$var'";
        return $sql;
    }


    public function get_Total_Pr_By_Single_user($var)
    {
        $this->Fconnection();

        $sql = mysql_query("SELECT * FROM `scm_approval_tree` WHERE pr_by = '$var'");

        return $sql;
    }


    public function get_Total_Pr_By_Subordinate_user($var)
    {
        $this->Fconnection();

        $sql = mysql_query("select scm_approval_tree.pr_id,tbl_tier.employee_id,admin_user_info.user_name FROM scm_approval_tree,tbl_tier,admin_user_info where scm_approval_tree.pr_by = tbl_tier.employee_id and scm_approval_tree.pr_by = admin_user_info.employee_id and( tbl_tier.tr1='$var' or tbl_tier.tr2='$var' or tbl_tier.tr3='$var' or tbl_tier.tr4='$var' or tbl_tier.tr5='$var' or tbl_tier.deligation='$var')");

        return $sql;
    }

    public function Total_Subordinate_Pr_Pending_For_Approval($var)
    {
        $this->Fconnection();

//$sSqlWrk = "SELECT employee_id,full_name FROM admin_user_info where employee_id='02-0323' or employee_id='02-0458' or employee_id='02-0007' order by full_name";

        $sql = mysql_query("select scm_approval_tree.pr_id,tbl_tier.employee_id,admin_user_info.user_name FROM scm_approval_tree,tbl_tier,admin_user_info where 
  scm_approval_tree.pr_by = tbl_tier.employee_id 
  and scm_approval_tree.pr_by = admin_user_info.employee_id 
  and ( tbl_tier.tr1='$var' or tbl_tier.tr2='$var' or tbl_tier.tr3='$var' or tbl_tier.tr4='$var' or tbl_tier.tr5='$var' or tbl_tier.deligation='$var') 
  and (scm_approval_tree.pr_approval_l1 IS NULL OR scm_approval_tree.pr_approval_l1 ='')");
// echo "select scm_approval_tree.pr_id,tbl_tier.employee_id,admin_user_info.user_name FROM scm_approval_tree,tbl_tier,admin_user_info where
//   scm_approval_tree.pr_by = tbl_tier.employee_id
//   and scm_approval_tree.pr_by = admin_user_info.employee_id
//   and ( tbl_tier.tr1='$var' or tbl_tier.tr2='$var' or tbl_tier.tr3='$var' or tbl_tier.tr4='$var' or tbl_tier.tr5='$var' or tbl_tier.deligation='$var')
//   and (scm_approval_tree.pr_approval_l1 IS NULL OR scm_approval_tree.pr_approval_l1 ='')";

        // $sql=mysql_query("select  from scm_approval_tree where pr_by IN(SELECT employee_id FROM tbl_tier WHERE tr1 = '$var' AND active ='Yes') and (`pr_approval_l1` IS NULL OR `pr_approval_l1` ='')");
        // echo "select scm_approval_tree.pr_id,tbl_tier.employee_id FROM scm_approval_tree,tbl_tier where scm_approval_tree.pr_by = tbl_tier.employee_id and (tbl_tier.employee_id='$var' or tbl_tier.tr1='$var' or tbl_tier.tr2='$var' or tbl_tier.tr3='$var' or tbl_tier.tr4='$var' or tbl_tier.tr5='$var' or tbl_tier.deligation='$var') and (scm_approval_tree.pr_approval_l1 IS NULL OR scm_approval_tree.pr_approval_l1 ='')";
        return $sql;
    }


    public function get_Total_Pending_PR_myself($var)
    {
        $this->Fconnection();
        $sql = mysql_query("SELECT *  FROM `scm_approval_tree` WHERE  pr_by='$var' AND (`pr_approval_l1` IS NULL OR `pr_approval_l1` ='')");
        // echo "SELECT *  FROM `scm_approval_tree` WHERE  pr_by='$var' AND (`pr_approval_l1` IS NULL OR `pr_approval_l1` ='')";
        return $sql;
    }

    public function get_Total_Pending_MR_myself($var)
    {
        $this->Fconnection();

//$sSqlWrk = "SELECT employee_id,full_name FROM admin_user_info where employee_id='02-0323' or employee_id='02-0458' or employee_id='02-0007' order by full_name";


        //$sql=mysql_query("SELECT count(*)  FROM `scm_approval_tree_inventory` WHERE  mr_by='$var' AND (`mr_approval_l1` IS NULL OR `mr_approval_l1` ='')");

        $sql = mysql_query("SELECT *  FROM `scm_approval_tree_inventory` WHERE  mr_by='$var' AND (`mr_approval_l1` IS NULL OR `mr_approval_l1` ='')");

        return $sql;
    }

    public function get_Total_downstream_MR_Pending($var)
    {
        $this->Fconnection();

//$sSqlWrk = "SELECT employee_id,full_name FROM admin_user_info where employee_id='02-0323' or employee_id='02-0458' or employee_id='02-0007' order by full_name";


        //$sql=mysql_query("SELECT count(*)  FROM `scm_approval_tree_inventory` WHERE  mr_by='$var' AND (`mr_approval_l1` IS NULL OR `mr_approval_l1` ='')");

        $sql = mysql_query("select scm_approval_tree_inventory.mr_id,tbl_tier.employee_id,admin_user_info.user_name FROM scm_approval_tree_inventory,tbl_tier,admin_user_info where scm_approval_tree_inventory.mr_by = tbl_tier.employee_id and scm_approval_tree_inventory.mr_by = admin_user_info.employee_id and( tbl_tier.tr1='$var' or tbl_tier.tr2='$var' or tbl_tier.tr3='$var' or tbl_tier.tr4='$var' or tbl_tier.tr5='$var' or tbl_tier.deligation='$var') and (scm_approval_tree_inventory.mr_approval_l1 IS NULL OR scm_approval_tree_inventory.mr_approval_l1 ='')");
//echo "select scm_approval_tree_inventory.mr_id,tbl_tier.employee_id,admin_user_info.user_name FROM scm_approval_tree_inventory,tbl_tier,admin_user_info where scm_approval_tree_inventory.mr_by = tbl_tier.employee_id and scm_approval_tree_inventory.mr_by = admin_user_info.employee_id and( tbl_tier.tr1='$var' or tbl_tier.tr2='$var' or tbl_tier.tr3='$var' or tbl_tier.tr4='$var' or tbl_tier.tr5='$var' or tbl_tier.deligation='$var') and (scm_approval_tree_inventory.mr_approval_l1 IS NULL OR scm_approval_tree_inventory.mr_approval_l1 ='')";
        return $sql;
    }

    public function get_Total_downstream_MR($var)
    {
        $this->Fconnection();

//$sSqlWrk = "SELECT employee_id,full_name FROM admin_user_info where employee_id='02-0323' or employee_id='02-0458' or employee_id='02-0007' order by full_name";


        //$sql=mysql_query("SELECT count(*)  FROM `scm_approval_tree_inventory` WHERE  mr_by='$var' AND (`mr_approval_l1` IS NULL OR `mr_approval_l1` ='')");

        $sql = mysql_query("select scm_approval_tree_inventory.mr_id,scm_approval_tree_inventory.mr_approval_l1,tbl_tier.employee_id,admin_user_info.user_name FROM scm_approval_tree_inventory,tbl_tier,admin_user_info where scm_approval_tree_inventory.mr_by = tbl_tier.employee_id and scm_approval_tree_inventory.mr_by = admin_user_info.employee_id and( tbl_tier.tr1='$var' or tbl_tier.tr2='$var' or tbl_tier.tr3='$var' or tbl_tier.tr4='$var' or tbl_tier.tr5='$var' or tbl_tier.deligation='$var')");

        return $sql;
    }

    public function insert_file_attachment_cancel_pr($table)
    {
        $this->Fconnection();
        $sql = "INSERT INTO `tbl_cancel_pr_attachment`(pr_info_fk, attachment_name ) VALUES ($table[0],'$table[1]')";


//        $sql="INSERT INTO `tbl_cancel_pr_attachment`(pr_info_fk, attachment_name ) VALUES (2,'bangladesht')";
        $exec = mysql_query($sql);

        return $exec;

    }

    public function find_file_attachment_cancel_pr($table)
    {
        $this->Fconnection();
//        $sql="INSERT INTO `tbl_cancel_pr_attachment`(pr_info_fk, attachment_name ) VALUES ($table[0],'$table[1]')";
        $sql = "SELECT * FROM `tbl_cancel_pr_attachment` WHERE pr_info_fk = $table";

        $exec = mysql_query($sql);

        while ($allAlterEmployeeData = mysql_fetch_array($exec)) {
            $dataSet[] = $allAlterEmployeeData;
        }
        return $dataSet;


//        $sql="INSERT INTO `tbl_cancel_pr_attachment`(pr_info_fk, attachment_name ) VALUES (2,'bangladesht')";


    }


//update current_item_info_fainal for reporting
    public function UpdateCurrentItemInfoFainal($table)
    {
        $this->Fconnection();

        $sql = mysql_query("UPDATE $table, all_item_info SET $table.item_code_inv = all_item_info.item_code,
$table.group = all_item_info.group_name,
$table.group_id = all_item_info.group_id,
$table.main_group_account = all_item_info.accounts_group
WHERE $table.item_id = all_item_info.item_id");
        echo "UPDATE $table, all_item_info SET $table.item_code_inv = all_item_info.item_code,
$table.group = all_item_info.group_name,
$table.group_id = all_item_info.group_id,
$table.main_group_account = all_item_info.accounts_group
WHERE $table.item_id = all_item_info.item_id";
        // $affected_rows=$this->Fconnection()->affected_rows;
        return $sql;
    }


    public function testf()
    {
        $this->Fconnection();

        return "HI";
    }


    public function Subordinate_employee_name($empData)
    {
        $this->Fconnection();

        $sql = mysql_query("");
    }


    public function geSingleUsageReportData($var)
    {
        $this->Fconnection();

        $sql = mysql_query("SELECT * FROM `tbl_report_usage_02_01_2017_temp` where id =$var");

//echo $sql;
        return $sql;
    }

    public function get_User_Name($var)
    {
        $this->Fconnection();
        $sql = mysql_query("SELECT * FROM admin_user_info where employee_id ='$var'");

//echo "SELECT * FROM admin_user_info where employee_id ='$var'";
        return $sql;
    }

    public function update_tmp_item_info_split_purpose($var)
    {
        $this->Fconnection();
        $sql = mysql_query("update tmp_item_info set pr_id='$var[0]' where item_tb_id=$var[1]");

//echo "update tmp_item_info set pr_id='$var[0]' where item_tb_id=$var[1]";
        return $sql;
    }

    public function get_row_from_tbl_report_usage($var)
    {
        $this->Fconnection();
        $sql = mysql_query("SELECT  `value_sub_group`, `value_item_name`,  `qty` , start_reading_name , end_reading_name,local_co_id,district_name ,flag,review_status,employee_id  FROM `tbl_report_usage_02_01_2017` WHERE id=$var");

        //  if($_SESSION['employee_id']=='02-0504'){echo "SELECT  `value_sub_group`, `value_item_name`,  `qty` , start_reading_name , end_reading_name,local_co_id,district_name ,flag,review_status  FROM `tbl_report_usage_02_01_2017` WHERE id=$var";}


        // echo "SELECT  SELECT  `value_sub_group`, `value_item_name`,  `qty` , start_reading_name , end_reading_name,local_co_id,district_name,flag,review_status FROM `tbl_report_usage_02_01_2017` WHERE id=$var";

        $val = mysql_fetch_array($sql);


        return $val;
    }

    public function get_row_from_current_item_info_fainal_local_co($var, $local_co_id)
    {
        $this->Fconnection();


        $sql = mysql_query("SELECT `id`, `item_tb_id`, `item_id`, `item_name`, `qty`, `unit`, `sub_group`, `sub_group_id`, `group`, `group_id`, `main_group_account`, `main_group_account_id`, `moving_type`, `last_purchase`, `unit_price`, `total_value`, `fmoving_critical_status`, `datei`, `in_out_status`, `user_id`, `pr_id`, `pq_id`, `po_id`, `mr_id`, `project_id`, `licence_id`, `project_id_exp`, `vandor_id`, `status`, `issue2_user_id`, `issue_date`, `expence_type`, `scr_id`, `invtrack_id`, `gr_id`, `mi_id`, `request_qty`, `previous_qty`, `item_code_inv`, `ref_no`, `lc_no`, `district`, `rq_id`,upazila_id,union_id,local_co_id FROM `current_item_info_fainal_local_co_infosarkar` WHERE item_id=$var and local_co_id='$local_co_id' order by id desc limit 1
        ");
        /*   echo "SELECT `id`, `item_tb_id`, `item_id`, `item_name`, `qty`, `unit`, `sub_group`, `sub_group_id`, `group`, `group_id`, `main_group_account`, `main_group_account_id`, `moving_type`, `last_purchase`, `unit_price`, `total_value`, `fmoving_critical_status`, `datei`, `in_out_status`, `user_id`, `pr_id`, `pq_id`, `po_id`, `mr_id`, `project_id`, `licence_id`, `project_id_exp`, `vandor_id`, `status`, `issue2_user_id`, `issue_date`, `expence_type`, `scr_id`, `invtrack_id`, `gr_id`, `mi_id`, `request_qty`, `previous_qty`, `item_code_inv`, `ref_no`, `lc_no`, `district`, `rq_id`,upazila_id,union_id,local_co_id FROM `current_item_info_fainal_local_co_infosarkar` WHERE item_id=$var and local_co_id='$local_co_id' order by id desc limit 1
        ";*/

        $data = mysql_fetch_row($sql);
        return $data;
    }


    public function get_row_from_current_item_info_fainal_local_co_general($var, $local_co_id)
    {
        $this->Fconnection();


        $sql = mysql_query("SELECT `id`, `item_tb_id`, `item_id`, `item_name`, `qty`, `unit`, `sub_group`, `sub_group_id`, `group`, `group_id`, `main_group_account`, `main_group_account_id`, `moving_type`, `last_purchase`, `unit_price`, `total_value`, `fmoving_critical_status`, `datei`, `in_out_status`, `user_id`, `pr_id`, `pq_id`, `po_id`, `mr_id`, `project_id`, `licence_id`, `project_id_exp`, `vandor_id`, `status`, `issue2_user_id`, `issue_date`, `expence_type`, `scr_id`, `invtrack_id`, `gr_id`, `mi_id`, `request_qty`, `previous_qty`, `item_code_inv`, `ref_no`, `lc_no`, `district`, `rq_id`,upazila_id,union_id,local_co_id FROM `current_item_info_fainal_local_co` WHERE item_id=$var and local_co_id='$local_co_id' order by id desc limit 1");
        // if($_SESSION['employee_id']=='02-0504'){echo "SELECT `id`, `item_tb_id`, `item_id`, `item_name`, `qty`, `unit`, `sub_group`, `sub_group_id`, `group`, `group_id`, `main_group_account`, `main_group_account_id`, `moving_type`, `last_purchase`, `unit_price`, `total_value`, `fmoving_critical_status`, `datei`, `in_out_status`, `user_id`, `pr_id`, `pq_id`, `po_id`, `mr_id`, `project_id`, `licence_id`, `project_id_exp`, `vandor_id`, `status`, `issue2_user_id`, `issue_date`, `expence_type`, `scr_id`, `invtrack_id`, `gr_id`, `mi_id`, `request_qty`, `previous_qty`, `item_code_inv`, `ref_no`, `lc_no`, `district`, `rq_id`,upazila_id,union_id,local_co_id FROM `current_item_info_fainal_local_co` WHERE item_id=$var and local_co_id='$local_co_id' order by id desc limit 1";}

        //   echo "SELECT `id`, `item_tb_id`, `item_id`, `item_name`, `qty`, `unit`, `sub_group`, `sub_group_id`, `group`, `group_id`, `main_group_account`, `main_group_account_id`, `moving_type`, `last_purchase`, `unit_price`, `total_value`, `fmoving_critical_status`, `datei`, `in_out_status`, `user_id`, `pr_id`, `pq_id`, `po_id`, `mr_id`, `project_id`, `licence_id`, `project_id_exp`, `vandor_id`, `status`, `issue2_user_id`, `issue_date`, `expence_type`, `scr_id`, `invtrack_id`, `gr_id`, `mi_id`, `request_qty`, `previous_qty`, `item_code_inv`, `ref_no`, `lc_no`, `district`, `rq_id`,upazila_id,union_id,local_co_id FROM `current_item_info_fainal_local_co` WHERE item_id=$var and local_co_id='$local_co_id' order by id desc limit 1
        // ";

        $data = mysql_fetch_row($sql);
        return $data;
    }


    public function deduct_current_local_data($current_val, $values, $request_qty, $local_co_id, $row_id)
    {
        $this->Fconnection();

        $sql_query = "insert into current_item_info_fainal_local_co (item_tb_id,item_id,item_name,qty,unit,sub_group,sub_group_id,`group`,group_id,`main_group_account`, `main_group_account_id`, `moving_type`, `last_purchase`, `unit_price`, `total_value`, `fmoving_critical_status`, `datei`, `in_out_status`, `user_id`, `pr_id`, `pq_id`, `po_id`, `mr_id`, `request_qty`, `previous_qty`, `item_code_inv`, `district`,upazila_id,union_id,local_co_id,usage_report_table_row_id)
values ('$values[1]','$values[2]','$values[3]',$current_val,'$values[5]','$values[6]','$values[7]','$values[8]','$values[9]','$values[10]','$values[11]','$values[12]','$values[13]','$values[14]','$values[15]','$values[16]',now(),2,'$_SESSION[employee_id]','0','0','0','0','$request_qty','$values[4]','$values[38]','$values[41]','$values[42]','$values[43]','$local_co_id',$row_id)";

//echo $sql_query;
        $sql = mysql_query("$sql_query");

        return $data;
    }

    public function deduct_current_local_data_infosarker($current_val, $values, $request_qty)
    {
        $this->Fconnection();

        $sql_query = "insert into current_item_info_fainal_local_co_infosarkar (item_tb_id,item_id,item_name,qty,unit,sub_group,sub_group_id,`group`,group_id,`main_group_account`, `main_group_account_id`, `moving_type`, `last_purchase`, `unit_price`, `total_value`, `fmoving_critical_status`, `datei`, `in_out_status`, `user_id`, `pr_id`, `pq_id`, `po_id`, `mr_id`, `request_qty`, `previous_qty`, `item_code_inv`, `district`,upazila_id,union_id,local_co_id )
values ('$values[1]','$values[2]','$values[3]',$current_val,'$values[5]','$values[6]','$values[7]','$values[8]','$values[9]','$values[10]','$values[11]','$values[12]','$values[13]','$values[14]','$values[15]','$values[16]',now(),2,'$values[19]','0','0','0','0','$request_qty','$values[4]','$values[38]','$values[41]','$values[43]','$values[44]','$values[45]')";

//echo $sql_query;
        $sql = mysql_query("$sql_query");

        return $data;
    }


    public function approved_usage_report_($var)
    {
        $this->Fconnection();

        $pr2_add_sql = mysql_query("$sql_query");

        $sql = mysql_query("update tmp_item_info set pr_id='$var[0]' where item_tb_id=$var[1]");

//echo "update tmp_item_info set pr_id='$var[0]' where item_tb_id=$var[1]";
        return $sql;
    }


    public function client_name_list()
    {
        $this->Fconnection();

        $select_all_client_list_sql = mysql_query("select * from client_info order by client_name");

        /*  while ($all_client_list = mysql_fetch_array($select_all_client_list_sql)) {
                $client_data[] = $all_client_list;
            }*/
        return $select_all_client_list_sql;

    }

    public function get_Upazila_Id()
    {
        $this->Fconnection();

        $select_all_client_list_sql = mysql_query("SELECT id,upazila_name FROM `upazila_name_scm` order by upazila_name");
        //echo "SELECT id,upazila_name FROM `upazila_name_scm`";
        return $select_all_client_list_sql;
    }

    public function get_name_from_table($table, $id)
    {
        $this->Fconnection();

        $select_all_client_list_sql = mysql_query("SELECT * FROM `$table` where id = $id");
        //echo "SELECT id,upazila_name FROM `upazila_name_scm`";
        $data = mysql_fetch_row($select_all_client_list_sql);
        return $data;
    }

    public function get_Union_Id()
    {
        $this->Fconnection();

        $select_all_client_list_sql = mysql_query("SELECT id,union_name FROM `union_name_scm` order by union_name ");
        //echo "SELECT id,union_name FROM `union_name_scm`";
        return $select_all_client_list_sql;

    }

    //to check user is eligible for infosarker inventory
    public function get_user_info_usage_report_concern($id)
    {
        $this->Fconnection();

        $data = mysql_query("SELECT * FROM `tbl_tier_infosarker` WHERE `employee_id` ='$id'");
//echo "SELECT * FROM `tbl_tier_infosarker` WHERE `employee_id` ='$id'";
        $var = mysql_num_rows($data);

        return $var;

    }

//to check user is eligible for F@H inventory
    public function get_user_info_usage_report_concern_general($id)
    {
        $this->Fconnection();

        $data = mysql_query("SELECT * FROM `tbl_tier_for_usage_report_16_oct` WHERE `employee_id` ='$id'");
//echo "SELECT * FROM `tbl_tier_for_usage_report_16_oct` WHERE `employee_id` ='$id'";
        $var = mysql_num_rows($data);

        return $var;

    }

//to get user tier and eligible for approved general usage
    public function get_usage_gn_tier_data($id)
    {
        $this->Fconnection();
//SELECT * FROM `usage_gn_tier_` WHERE `ho_cordinator` IN('$id') or approved_by IN('$id')
        $data = mysql_query("SELECT * FROM `usage_gn_tier_` WHERE  approved_by IN('$id')");
//echo "SELECT * FROM `usage_gn_tier_` WHERE `ho_cordinator` IN('$id') or approved_by IN('$id')";
        $var = mysql_num_rows($data);

        return $var;

    }

    public function get_usage_user_level($col, $empl_id)
    {
        $this->Fconnection();
//SELECT * FROM `usage_gn_tier_` WHERE `ho_cordinator` IN('$id') or approved_by IN('$id')
        $data = mysql_query("SELECT * FROM `usage_gn_tier_` WHERE  $col = '$empl_id'");

        // if($_SESSION['employee_id']=='02-0629'){echo "SELECT * FROM `usage_gn_tier_` WHERE  $col = '$empl_id'";       }


        return $data;

    }


    public function get_usage_gn_tier_data_review_by($id)
    {
        $this->Fconnection();
//SELECT * FROM `usage_gn_tier_` WHERE `ho_cordinator` IN('$id') or approved_by IN('$id')
        $data = mysql_query("SELECT * FROM `usage_gn_tier_` WHERE  ho_cordinator IN('$id')");
//echo "SELECT * FROM usage_gn_tier_ WHERE  ho_cordinator IN('$id')";
        $var = mysql_num_rows($data);

        return $var;

    }

    public function gr_list_infosarkar()
    {
        $this->Fconnection();

        $sql = mysql_query("SELECT * FROM `current_item_info_fainal_infosarkar` group by gr_id order by id");

//echo $sql;
        return $sql;
    }

    public function get_single_gr_details($id)
    {
        $this->Fconnection();

        $sql = mysql_query("SELECT * FROM `current_item_info_fainal_infosarkar` where  gr_id='$id'");

//echo "SELECT * FROM `current_item_info_fainal_infosarkar` where  gr_id='$id'";
        $fetch_data = mysql_fetch_row($sql);
        return $fetch_data;
    }

    public function rgr_auto_gen_()
    {
        $this->Fconnection();
        $today = date("Y-m-d");
        //$val=$_SESSION['employee_id'];
        $sql = "select max(id) from  current_item_info_fainal";
        //echo $sql;
        $grn_gen_max = mysql_query($sql);
        $grn_max_no = mysql_fetch_row($grn_gen_max);
        $a = $grn_max_no[0] + 1;
        $increment_value_grn = 'FAHSC' . $today . 'RGR' . $a;
        return $increment_value_grn;

    }

    public function getCAandInfo_pq($id)
    {
        $this->Fconnection();
        //  echo "select * from tbl_c_and_form where pq_id like '%$id%' ";
        $sql = mysql_query("select * from tbl_c_and_form where pq_id like '%$id%' ");

        while ($all_data = mysql_fetch_array($sql)) {
            $product_list[] = $all_data;
        }
        return $product_list;
    }

    public function get_MI_ID($val)
    {
        $this->Fconnection();

        $sql = mysql_query("SELECT mi_id FROM `current_item_info_fainal` where mr_id='$val' limit 1");
        $all_data = mysql_fetch_row($sql);
//echo $sql;
        return $all_data;
    }

    public function get_MI_ID_Infosarkar($val)
    {
        $this->Fconnection();

        $sql = mysql_query("SELECT mi_id FROM `current_item_info_fainal_infosarkar` where mr_id='$val' limit 1");
        $all_data = mysql_fetch_row($sql);
//echo $sql;
        return $all_data;
    }

    public function get_item_id_by_name($name)
    {
        $this->Fconnection();
        $sql = "select * from  all_item_info where item_name like '%$name%'";
        $grn_gen_max = mysql_query($sql);

        while ($row = mysql_fetch_assoc($grn_gen_max)) {
            $array[] = $row['item_id'];
        }
        return $array;

    }

    public function item_info_individual_rq_total_general($item, $mi_id)
    {
        $this->Fconnection();
        $sql1 = "SELECT item_id as item_tb_id, item_id, item_name, sub_group, sub_group_id, `group`, group_id, qty, unit, item_id as item_id1, item_code_inv,sum(request_qty) FROM current_item_info_fainal_local_co where item_id='$item' and mi_id='$mi_id' group by mi_id,item_id";
        // echo $sql1;
        $select_all_item_sql1 = mysql_query("$sql1");
        $item_list_info1 = mysql_fetch_array($select_all_item_sql1);
        return $item_list_info1;
    }

    public function item_info_individual_rq_total_infosarker($item, $mi_id)
    {
        $this->Fconnection();
        $sql1 = "SELECT item_id as item_tb_id, item_id, item_name, sub_group, sub_group_id, `group`, group_id, qty, unit, item_id as item_id1, item_code_inv,sum(request_qty) FROM current_item_info_fainal_local_co_infosarkar where item_id='$item' and mi_id='$mi_id' group by mi_id,item_id";
//  echo $sql1;
        $select_all_item_sql1 = mysql_query("$sql1");
        $item_list_info1 = mysql_fetch_array($select_all_item_sql1);
        return $item_list_info1;
    }


    public function item_info_individual_single_rq_total_local_co_infosarker($item, $rq_id)
    {
        $this->Fconnection();
        $sql1 = "SELECT item_id as item_tb_id, item_id, item_name, sub_group, sub_group_id, `group`, group_id, qty, unit, item_id as item_id1, item_code_inv,sum(request_qty) FROM current_item_info_fainal_local_co_infosarkar where item_id='$item' and rq_id='$rq_id' group by rq_id,item_id";
        //echo $sql1;
        $select_all_item_sql1 = mysql_query("$sql1");
        $item_list_info1 = mysql_fetch_array($select_all_item_sql1);
        return $item_list_info1;
    }

    public function item_info_individual_single_rq_total_local_co_general($item, $rq_id)
    {
        $this->Fconnection();
        $sql1 = "SELECT item_id as item_tb_id, item_id, item_name, sub_group, sub_group_id, `group`, group_id, qty, unit, item_id as item_id1, item_code_inv,sum(request_qty) FROM current_item_info_fainal_local_co where item_id='$item' and rq_id='$rq_id' group by rq_id,item_id";

//if($_SESSION['employee_id']=='02-0838'){	 echo $sql1;   }
        $select_all_item_sql1 = mysql_query("$sql1");
        $item_list_info1 = mysql_fetch_array($select_all_item_sql1);
        return $item_list_info1;
    }

    public function current_item_info_fainal_unique_mr_rq_purpose($val)
    {
        $this->Fconnection();

        $sql = "select * from  current_item_info_fainal_infosarkar
      where mr_id='$val'";
        // echo "$sql";
        $scm_approval_tree_sql_mr = mysql_query("$sql");
        $scm_approval_tree_mr = mysql_fetch_array($scm_approval_tree_sql_mr);
        return $scm_approval_tree_mr;
    }

    public function current_item_info_fainal_unique_mr_rq_purpose_general($val)
    {
        $this->Fconnection();

        $sql = "select * from  current_item_info_fainal
      where mr_id='$val'";
        // echo "$sql";
        $scm_approval_tree_sql_mr = mysql_query("$sql");
        $scm_approval_tree_mr = mysql_fetch_array($scm_approval_tree_sql_mr);
        return $scm_approval_tree_mr;
    }

    public function select_all_mi_id($mr_id)
    {
        $this->Fconnection();

        $select_all_client_list_sql = mysql_query("select * from current_item_info_fainal_infosarkar where mr_id='$mr_id' group by mi_id");
        // echo "select * from current_item_info_fainal_infosarkar where mr_id='$mr_id'";
        return $select_all_client_list_sql;

    }

    public function select_all_general_mi_id($mr_id)
    {
        $this->Fconnection();

        $select_all_client_list_sql = mysql_query("select * from current_item_info_fainal where mr_id='$mr_id' group by mi_id");
        //echo "select * from current_item_info_fainal where mr_id='$mr_id'";
        return $select_all_client_list_sql;

    }

    public function project_info_new_data($mr_id)
    {
        $this->Fconnection();

        $select_all_client_list_sql = mysql_query("select * from project_info_new where infosarker=1 ORDER BY project_name");
        // echo "select * from current_item_info_fainal_infosarkar where mr_id='$mr_id'";
        return $select_all_client_list_sql;

    }

    public function add_local_co_item_row_if_not_found($data)
    {
        $this->Fconnection();

        $select_all_client_list_sql = mysql_query("insert into `current_item_info_fainal_local_co` ( `item_tb_id`, `item_id`, `item_name`, `qty`, `unit`, `sub_group`, `sub_group_id`, `group`, `group_id`, `main_group_account`, `main_group_account_id`, `moving_type`, `last_purchase`, `unit_price`, `total_value`, `fmoving_critical_status`, `datei`, `in_out_status`, `user_id`, `pr_id`, `pq_id`, `po_id`, `mr_id`, `project_id`, `licence_id`, `project_id_exp`, `vandor_id`, `status`, `issue2_user_id`, `issue_date`, `expence_type`, `scr_id`, `invtrack_id`, `gr_id`, `mi_id`, `request_qty`, `previous_qty`, `item_code_inv`, `ref_no`, `lc_no`, `district`,`local_co_id`, `upazila_id`, `union_id`, `rq_id`) 

SELECT `item_tb_id`, `item_id`, `item_name`, 0, `unit`, `sub_group`, `sub_group_id`, `group`, `group_id`, `main_group_account`, `main_group_account_id`, `moving_type`, `last_purchase`, 0, 0, `fmoving_critical_status`, `datei`, `in_out_status`, `user_id`, 0, 0, 0, 0, `project_id`, `licence_id`, `project_id_exp`, 0, `status`, `issue2_user_id`, `issue_date`, `expence_type`, 0, `invtrack_id`, 0, 0, 0, 0, `item_code_inv`, 0, 0, '$data[30]', '$data[34]', '$data[32]', '$data[33]', `rq_id` from current_item_info_fainal WHERE item_id =$data[0] ");


        $info = mysql_insert_id();
        return $info;
    }

    public function add_local_co_item_row_if_not_found_infosarker($data)
    {
        $this->Fconnection();

        $select_all_client_list_sql = mysql_query("insert into `current_item_info_fainal_local_co_infosarkar` ( `item_tb_id`, `item_id`, `item_name`, `qty`, `unit`, `sub_group`, `sub_group_id`, `group`, `group_id`, `main_group_account`, `main_group_account_id`, `moving_type`, `last_purchase`, `unit_price`, `total_value`, `fmoving_critical_status`, `datei`, `in_out_status`, `user_id`, `pr_id`, `pq_id`, `po_id`, `mr_id`, `project_id`, `licence_id`, `project_id_exp`, `vandor_id`, `status`, `issue2_user_id`, `issue_date`, `expence_type`, `scr_id`, `invtrack_id`, `gr_id`, `mi_id`, `request_qty`, `previous_qty`, `item_code_inv`, `ref_no`, `lc_no`, `district`,`local_co_id`, `upazila_id`, `union_id`, `rq_id`) 

SELECT `item_tb_id`, `item_id`, `item_name`, 0, `unit`, `sub_group`, `sub_group_id`, `group`, `group_id`, `main_group_account`, `main_group_account_id`, `moving_type`, `last_purchase`, 0, 0, `fmoving_critical_status`, `datei`, `in_out_status`, `user_id`, 0, 0, 0, 0, `project_id`, `licence_id`, `project_id_exp`, 0, `status`, `issue2_user_id`, `issue_date`, `expence_type`, 0, `invtrack_id`, 0, 0, 0, 0, `item_code_inv`, 0, 0, '$data[30]', '$data[34]', '$data[32]', '$data[33]', `rq_id` from current_item_info_fainal WHERE item_id =$data[0] ");


        $info = mysql_insert_id();
        return $info;
    }

    public function get_all_rq_to_usage_id($val1, $val2)
    {
        $this->Fconnection();

        $select_all_client_list_sql = mysql_query("select * from current_item_info_fainal_local_co_infosarkar 
          where id<>0 and rq_id!='' and district in ($val2) group by rq_id ");
        // echo "select * from current_item_info_fainal_infosarkar where mr_id='$mr_id'";
        return $select_all_client_list_sql;

    }

    public function auto_generated_usage_id()
    {


        $this->Fconnection();
        $today = date("Y-m-d");
        //$val=$_SESSION['employee_id'];
        $sql = "select * FROM    tbl_report_usage_02_01_2017 where status_infosarkar=1 GROUP BY usage_id";
        //echo $sql;
        $mi_gen_max = mysql_query($sql);
        $mi_max_no = mysql_num_rows($mi_gen_max);
        $a = $mi_max_no + 1;
        $increment_value_mi = 'INF03_USG' . $a;
        //echo $increment_value_mi;
        return $increment_value_mi;


    }


    public function auto_generated_usage_id_general()
    {


        $this->Fconnection();
        $today = date("Y-m-d");
        //$val=$_SESSION['employee_id'];
        $sql = "select * FROM    tbl_report_usage_02_01_2017 where id !=0 ";
        //echo $sql;
        $mi_gen_max = mysql_query($sql);
        $mi_max_no = mysql_num_rows($mi_gen_max);
        $a = $mi_max_no + 3;
        $increment_value_mi = 'FH_USG' . $a;
        //echo $increment_value_mi;
        return $increment_value_mi;


    }

    public function get_all_district_id_infosarker_item_owner($em_id)
    {
        $this->Fconnection();
        $sql = "select * from  tbl_tier_infosarker where employee_id = '$em_id'";
        //echo "select * from  tbl_tier_infosarker where employee_id = '$em_id'";
        $grn_gen_max = mysql_query($sql);

        while ($row = mysql_fetch_assoc($grn_gen_max)) {
            $array[] = $row['district'];
        }
        return $array;

    }


    public function get_all_district_id_FH_item_owner($em_id)
    {
        $this->Fconnection();
        $sql = "select * from  tbl_tier_for_usage_report_16_oct where employee_id = '$em_id'";
        // echo "select * from  tbl_tier_for_usage_report_16_oct where employee_id = '$em_id'";
        $grn_gen_max = mysql_query($sql);

        while ($row = mysql_fetch_assoc($grn_gen_max)) {
            $array[] = $row['district'];
        }
        return $array;

    }

// to show
    public function item_info_individual_single_rq_total_local_co_infosarker_from_tbl_report_usage($item, $rq_id)
    {
        $this->Fconnection();
        $sql1 = "SELECT value_item_name, item_name, value_sub_group, group_name,sum(qty) FROM tbl_report_usage_02_01_2017 where value_item_name='$item' and rq_id='$rq_id' group by rq_id,value_item_name";
//  echo $sql1;
        $select_all_item_sql1 = mysql_query("$sql1");
        $item_list_info1 = mysql_fetch_array($select_all_item_sql1);
        return $item_list_info1;
    }

// to show
    public function item_info_individual_single_rq_total_local_co_infosarker_from_tbl_report_usage_new($item, $mr_id, $rq_id)
    {
        $this->Fconnection();
        $sql1 = "SELECT value_item_name, item_name, value_sub_group, group_name,sum(qty) FROM tbl_report_usage_02_01_2017 where value_item_name='$item' and mr_id='$mr_id' and rq_id='$rq_id' group by rq_id,value_item_name";
//  echo $sql1;
        $select_all_item_sql1 = mysql_query("$sql1");
        $item_list_info1 = mysql_fetch_array($select_all_item_sql1);
        return $item_list_info1;
    }

    //to show all overbangladesh concern product report
    public function inventory_update_info_local_co_personal($statement, $start_from, $num_rec_per_page, $district)
    {
        $this->Fconnection();
        $sql1 = "select tt.* from current_item_info_fainal_local_co tt INNER JOIN (SELECT item_tb_id, MAX(id) AS id1 FROM current_item_info_fainal_local_co   GROUP BY item_tb_id, district) cciif ON tt.item_tb_id = cciif.item_tb_id AND tt.id = cciif.id1 and tt.user_id ='$district' and tt.qty!=''   order by tt.item_tb_id desc ";
        if ($_SESSION['employee_id'] == '02-0629') {
            echo $sql1;
        }
        $select_all_item_sql1 = mysql_query("$sql1");

        return $select_all_item_sql1;
    }

    public function mr_concern_list_fh()
    {

        $this->Fconnection();
        $sql1 = "SELECT full_name
  FROM `admin_user_info` where mr_concern_fh=1";
        //echo $sql1;
        $select_all_item_sql1 = mysql_query("$sql1");

        return $select_all_item_sql1;

    }

    public function mr_auto_gen_temp()
    {
        $this->Fconnection();
        $today = date("Y-m-d");
        $val = $_SESSION['employee_id'];
        $sql = "select * FROM    mr_info1_temp GROUP BY mr_id";
        //echo $sql;
        $mi_gen_max = mysql_query($sql);
        $max = mysql_num_rows($mi_gen_max);
        $a = $max + 100;
        $increment_value_mi = 'FAH' . $today . 'MR' . $a;
        //echo $increment_value_mi;
        return $increment_value_mi;


    }

//inventory module function start
    public function inventory_update_info_opening($statement, $item_id)
    {
        $this->Fconnection();

        //$sql1="select * from current_item_info_fainal where current_item_info_fainal.id<>0 and current_item_info_fainal.id in (select min(id) from current_item_info_fainal where item_id='$item_id' group by item_id)  $statement order by item_name";
        //$sql1="select qty from current_item_info_fainal where current_item_info_fainal.id<>0 and current_item_info_fainal.id in (select min(id) from current_item_info_fainal where item_id='$item_id')  $statement";
        $sql1 = "select tt.qty from current_item_info_fainal tt INNER JOIN (SELECT item_tb_id, MIN(id) AS id1 FROM current_item_info_fainal where item_id='$item_id' GROUP BY item_tb_id) cciif ON tt.item_tb_id = cciif.item_tb_id AND tt.id = cciif.id1 and tt.item_code_inv!=''  $statement";

        //echo $sql1;
        $select_all_item_sql1 = mysql_query("$sql1");
        $item_list_info1 = mysql_fetch_array($select_all_item_sql1);
        return $item_list_info1;
    }

    public function inventory_update_info_received($statement, $item_id)
    {
        $this->Fconnection();

        $sql1 = "select sum(request_qty) from current_item_info_fainal where current_item_info_fainal.id<>0 and item_id='$item_id' and in_out_status=1 $statement group by item_id";
        //echo $sql1;
        $select_all_item_sql1 = mysql_query("$sql1");
        $item_list_info1 = mysql_fetch_array($select_all_item_sql1);
        return $item_list_info1;
    }

    public function inventory_update_info_issued($statement, $item_id)
    {
        $this->Fconnection();

        $sql1 = "select sum(request_qty) from current_item_info_fainal where current_item_info_fainal.id<>0 and item_id='$item_id' and in_out_status=2 $statement group by item_id";
        //echo $sql1;
        $select_all_item_sql1 = mysql_query("$sql1");
        $item_list_info1 = mysql_fetch_array($select_all_item_sql1);
        return $item_list_info1;
    }

    //inventory module function end

    public function get_all_over_bd_item_owner($em_id)
    {
        $this->Fconnection();
        $sql = "select * from  tbl_tier_all_over_bd_for_gen_usage_report where employee_id='$em_id' or  tr1='$em_id' or  tr2='$em_id' or tr3='$em_id' or  tr4='$em_id' or  tr5='$em_id'";
        //  echo "select * from  tbl_tier_all_over_bd_for_gen_usage_report where employee_id='$em_id' or  tr1='$em_id' or  tr2='$em_id' or tr3='$em_id' or  tr4='$em_id' or  tr5='$em_id'";
        $grn_gen_max = mysql_query($sql);

        while ($row = mysql_fetch_assoc($grn_gen_max)) {
            $array[] = $row['employee_id'];
        }
        return $array;

    }

    public function geUsageReportSummeryView($table_name, $status, $flag, $district, $statement)
    {
        if (!$district) {
            $district = "''";
        }
        if (!$status) {
            $status = 1;
        }
        if (!$flag) {
            $flag = 0;
        }


        $this->Fconnection();
        //"SELECT * from $table_name WHERE save_submit_status = $status and local_co_id='$district' and flag=$flag"
        if ($_SESSION['employee_id'] == '02-0047' || $_SESSION['employee_id'] == '02-0800') {
            //echo  "SELECT * from $table_name order by id desc";
            //$sql = mysql_query("SELECT * from $table_name WHERE mr_id !=''order by id desc");
            $sql = mysql_query("SELECT * from $table_name order by id desc");
        } else {
            $sql = mysql_query("SELECT * from $table_name WHERE flag = $flag AND mr_id !='' and review_status=$status and district_name IN($district) $statement order by id desc");
        }

        if ($_SESSION['employee_id'] == '02-1626') {
            echo "SELECT * from $table_name WHERE flag = $flag and review_status=$status and district_name IN($district) $statement order by id desc";
        }

        while ($pr_p0_gridview_list = mysql_fetch_array($sql)) {
            $pr_p0_gridview[] = $pr_p0_gridview_list;
        }


        return $pr_p0_gridview;
    }

    public function geUsageReportSummeryView_single_person($table_name, $status, $flag, $district)
    {
        $employee_id = $_SESSION['employee_id'];
        $this->Fconnection();
        //"SELECT * from $table_name WHERE save_submit_status = $status and local_co_id='$district' and flag=$flag"
        $sql = mysql_query("SELECT * from $table_name WHERE  employee_id='$employee_id' AND mr_id !='' ORDER BY value_item_name ");
        // if($_SESSION['employee_id']=='02-0869'){echo "SELECT * from $table_name WHERE flag = $flag  and employee_id='$employee_id' AND mr_id !='' ORDER BY value_item_name";}

        //echo "SELECT * from $table_name WHERE flag = $flag and district_name IN($district) and employee_id='$employee_id' ORDER BY value_item_name";
//echo "SELECT * from $table_name WHERE flag = $flag and district_name IN($district)";
        return $sql;
    }

    public function geTsingle_person_review_by_data($table_name, $status, $flag, $district)
    {
        $employee_id = $_SESSION['employee_id'];
        $this->Fconnection();
        //"SELECT * from $table_name WHERE save_submit_status = $status and local_co_id='$district' and flag=$flag"
        $sql = mysql_query("SELECT * from $table_name WHERE  review_by='$employee_id' ORDER BY value_item_name");
        // if($_SESSION['employee_id']=='02-0282'){echo "SELECT * from $table_name WHERE  review_by='$employee_id' ORDER BY value_item_name";}


        return $sql;
    }


    public function geUsageReportSummeryView_all_over_bd($table_name, $status, $flag, $district)
    {
        $this->Fconnection();
        //"SELECT * from $table_name WHERE save_submit_status = $status and local_co_id='$district' and flag=$flag"
        $sql = mysql_query("SELECT * from $table_name WHERE flag = $flag and  employee_id in ($district) order by id desc");
        // echo "SELECT * from $table_name WHERE flag = $flag and  employee_id in ($district)";

        while ($pr_p0_gridview_list = mysql_fetch_array($sql)) {
            $pr_p0_gridview[] = $pr_p0_gridview_list;
        }

        return $pr_p0_gridview;
    }

    //mr edit from inventory user
    public function save_mr_info1_table_data($table_mr_info1, $mr_id)
    {
        $user_id_id = $_SESSION['employee_id'];
        $this->Fconnection();

        $mr_p0_details_sql = mysql_query("INSERT INTO `mr_info1_temp_for_updt_dt_bup`( `mr_id`, `mr_type`, `mr_date`, `mr_by`, `mr_expected_date`, `mr_porpuse`, `expense_type`, `meterial_type`, `total_estimated_cost`, `delivery_instruction`, `remarks`, `status`, `date`, `user`, `license_id`, `co_id`, `mr_verify_by`, `mr_verify_date`, `mr_approve_by`, `mr_approval_date`, `uploaded_file`, `project_id`, `project_id_new`, `project_id_new_for`, `exp_description`, `expected_date`, `employee_to`, `mr_approval_l1`, `mr_approval_l1_date`, `mr_approval_l2`, `mr_approval_l2_date`, `mr_approval_l3`, `mr_approval_l3_date`, `district`, `upazilla_id`, `union_id`, `local_co_id`, `flag` ,update_user_id,datetimed)
SELECT  `mr_id`, `mr_type`, `mr_date`, `mr_by`, `mr_expected_date`, `mr_porpuse`, `expense_type`, `meterial_type`, `total_estimated_cost`, `delivery_instruction`, `remarks`, `status`, `date`, `user`, `license_id`, `co_id`, `mr_verify_by`, `mr_verify_date`, `mr_approve_by`, `mr_approval_date`, `uploaded_file`, `project_id`, `project_id_new`, `project_id_new_for`, `exp_description`, `expected_date`, `employee_to`, `mr_approval_l1`, `mr_approval_l1_date`, `mr_approval_l2`, `mr_approval_l2_date`, `mr_approval_l3`, `mr_approval_l3_date`, `district`, `upazilla_id`, `union_id`, `local_co_id`, `flag`,'$user_id_id',now() FROM `mr_info1`  WHERE mr_id ='$mr_id'");

        $mr_p0_info = mysql_fetch_array($mr_p0_details_sql);

        /* echo "INSERT INTO `mr_info1_temp_for_updt_dt_bup`( `mr_id`, `mr_type`, `mr_date`, `mr_by`, `mr_expected_date`, `mr_porpuse`, `expense_type`, `meterial_type`, `total_estimated_cost`, `delivery_instruction`, `remarks`, `status`, `date`, `user`, `license_id`, `co_id`, `mr_verify_by`, `mr_verify_date`, `mr_approve_by`, `mr_approval_date`, `uploaded_file`, `project_id`, `project_id_new`, `project_id_new_for`, `exp_description`, `expected_date`, `employee_to`, `mr_approval_l1`, `mr_approval_l1_date`, `mr_approval_l2`, `mr_approval_l2_date`, `mr_approval_l3`, `mr_approval_l3_date`, `district`, `upazilla_id`, `union_id`, `local_co_id`, `flag` ,update_user_id,datetimed)
SELECT  `mr_id`, `mr_type`, `mr_date`, `mr_by`, `mr_expected_date`, `mr_porpuse`, `expense_type`, `meterial_type`, `total_estimated_cost`, `delivery_instruction`, `remarks`, `status`, `date`, `user`, `license_id`, `co_id`, `mr_verify_by`, `mr_verify_date`, `mr_approve_by`, `mr_approval_date`, `uploaded_file`, `project_id`, `project_id_new`, `project_id_new_for`, `exp_description`, `expected_date`, `employee_to`, `mr_approval_l1`, `mr_approval_l1_date`, `mr_approval_l2`, `mr_approval_l2_date`, `mr_approval_l3`, `mr_approval_l3_date`, `district`, `upazilla_id`, `union_id`, `local_co_id`, `flag`,'$user_id_id',now() FROM `mr_info1`  WHERE mr_id ='$mr_id'";
*/
        return $mr_p0_info;
    }

    public function save_scm_approval_tree_table_data($table_mr_info1, $mr_id)
    {
        $this->Fconnection();

        $mr_p0_details_sql = mysql_query("INSERT INTO `scm_approval_tree_inventory_temp_for_updt_dt_bup`( `mr_id`, `mr_date`, `mr_by`, `mr_approval_l1`, `mr_approval_l1_date`, `mr_approval_l2`, `mr_approval_l2_date`, `mr_approval_l3`, `mr_approval_l3_date`, `mi_id`, `mi_date`, `mi_by`, `mi_approval_l1`, `mi_approval_l1_date`, `mi_approval_l2`, `mi_approval_l2_date`, `mi_approval_l3`, `mi_approval_l3_date`, `po_id`, `po_date`, `po_by`, `po_approval_l1`, `po_approval_l1_date`, `po_approval_l2`, `po_approval_l2_date`, `po_approval_l3`, `po_approval_l3_date`, `po_approval_au_l1`, `po_approval_au_l1_date`, `po_approval_ac_l2`, `po_approval_ac_l2_date`, `po_approval_ac_l3`, `po_approval_ac_l3_date`, `flag`, `pr_31`, `pq_31`, `po_31`, `pq_forwarded_to`, `pq_forwarded_date`, `pq_forwarded2it`, `pq_forwarded2it_date`, `pq_it_st`, `pq_it_date`)
SELECT `mr_id`, `mr_date`, `mr_by`, `mr_approval_l1`, `mr_approval_l1_date`, `mr_approval_l2`, `mr_approval_l2_date`, `mr_approval_l3`, `mr_approval_l3_date`, `mi_id`, `mi_date`, `mi_by`, `mi_approval_l1`, `mi_approval_l1_date`, `mi_approval_l2`, `mi_approval_l2_date`, `mi_approval_l3`, `mi_approval_l3_date`, `po_id`, `po_date`, `po_by`, `po_approval_l1`, `po_approval_l1_date`, `po_approval_l2`, `po_approval_l2_date`, `po_approval_l3`, `po_approval_l3_date`, `po_approval_au_l1`, `po_approval_au_l1_date`, `po_approval_ac_l2`, `po_approval_ac_l2_date`, `po_approval_ac_l3`, `po_approval_ac_l3_date`, `flag`, `pr_31`, `pq_31`, `po_31`, `pq_forwarded_to`, `pq_forwarded_date`, `pq_forwarded2it`, `pq_forwarded2it_date`, `pq_it_st`, `pq_it_date` FROM `scm_approval_tree_inventory`  WHERE mr_id ='$mr_id'");

        $mr_p0_info = mysql_fetch_array($mr_p0_details_sql);
        /*
    echo "INSERT INTO `scm_approval_tree_inventory_temp_for_updt_dt_bup`( `mr_id`, `mr_date`, `mr_by`, `mr_approval_l1`, `mr_approval_l1_date`, `mr_approval_l2`, `mr_approval_l2_date`, `mr_approval_l3`, `mr_approval_l3_date`, `mi_id`, `mi_date`, `mi_by`, `mi_approval_l1`, `mi_approval_l1_date`, `mi_approval_l2`, `mi_approval_l2_date`, `mi_approval_l3`, `mi_approval_l3_date`, `po_id`, `po_date`, `po_by`, `po_approval_l1`, `po_approval_l1_date`, `po_approval_l2`, `po_approval_l2_date`, `po_approval_l3`, `po_approval_l3_date`, `po_approval_au_l1`, `po_approval_au_l1_date`, `po_approval_ac_l2`, `po_approval_ac_l2_date`, `po_approval_ac_l3`, `po_approval_ac_l3_date`, `flag`, `pr_31`, `pq_31`, `po_31`, `pq_forwarded_to`, `pq_forwarded_date`, `pq_forwarded2it`, `pq_forwarded2it_date`, `pq_it_st`, `pq_it_date`)
SELECT `mr_id`, `mr_date`, `mr_by`, `mr_approval_l1`, `mr_approval_l1_date`, `mr_approval_l2`, `mr_approval_l2_date`, `mr_approval_l3`, `mr_approval_l3_date`, `mi_id`, `mi_date`, `mi_by`, `mi_approval_l1`, `mi_approval_l1_date`, `mi_approval_l2`, `mi_approval_l2_date`, `mi_approval_l3`, `mi_approval_l3_date`, `po_id`, `po_date`, `po_by`, `po_approval_l1`, `po_approval_l1_date`, `po_approval_l2`, `po_approval_l2_date`, `po_approval_l3`, `po_approval_l3_date`, `po_approval_au_l1`, `po_approval_au_l1_date`, `po_approval_ac_l2`, `po_approval_ac_l2_date`, `po_approval_ac_l3`, `po_approval_ac_l3_date`, `flag`, `pr_31`, `pq_31`, `po_31`, `pq_forwarded_to`, `pq_forwarded_date`, `pq_forwarded2it`, `pq_forwarded2it_date`, `pq_it_st`, `pq_it_date` FROM `scm_approval_tree_inventory`  WHERE mr_id ='$mr_id'";*/

        return $mr_p0_info;
    }

    public function mr_temp_item_info_temp_edit_inventory($values, $table_tmp_item_info_temp)
    {
        $this->Fconnection();
        $today = date("Y-m-d");

        $mr_p0_details_sql = mysql_query("INSERT INTO `tmp_item_info_mr_temp_temp_for_updt_dt_bup`( `item_id`, `item_name`, `description`, `ordered_quantity`, `unit`, `price_per_unit`, `total_value`, `remarks`, `status`, `mr_id`, `date`, `vat`, `item_name_new`, `sl`,item_tb_id_fk)
SELECT `item_id`, `item_name`, `description`, `ordered_quantity`, `unit`, `price_per_unit`, `total_value`, `remarks`, `status`, `mr_id`, `date`, `vat`, `item_name_new`, `sl`,item_tb_id FROM `tmp_item_info_mr` WHERE  mr_id='$values[4]' and item_tb_id=$values[6]");
        echo "INSERT INTO `tmp_item_info_mr_temp_temp_for_updt_dt_bup`( `item_id`, `item_name`, `description`, `ordered_quantity`, `unit`, `price_per_unit`, `total_value`, `remarks`, `status`, `mr_id`, `date`, `vat`, `item_name_new`, `sl`,item_tb_id_fk)
SELECT `item_id`, `item_name`, `description`, `ordered_quantity`, `unit`, `price_per_unit`, `total_value`, `remarks`, `status`, `mr_id`, `date`, `vat`, `item_name_new`, `sl`,item_tb_id FROM `tmp_item_info_mr` WHERE  mr_id='$values[4]' and item_tb_id=$values[6]";
        /*echo "INSERT INTO `tmp_item_info_mr_temp_temp_for_updt_dt_bup`( `item_id`, `item_name`, `description`, `ordered_quantity`, `unit`, `price_per_unit`, `total_value`, `remarks`, `status`, `mr_id`, `date`, `vat`, `item_name_new`, `sl`)
SELECT `item_id`, `item_name`, `description`, `ordered_quantity`, `unit`, `price_per_unit`, `total_value`, `remarks`, `status`, `mr_id`, `date`, `vat`, `item_name_new`, `sl` FROM `tmp_item_info_mr` WHERE  mr_id='$values[4]' and item_tb_id=$values[6]";
*/
        $mr_p0_info = mysql_fetch_array($mr_p0_details_sql);

        $sql = mysql_query("SELECT *  FROM  all_item_info WHERE item_id = '$values[0]'");
        // echo "SELECT *  FROM  all_item_info WHERE item_id = '$value_item_name[$i]'";
        $unit_val = mysql_fetch_row($sql);

        $pr_temp_item_info_edit = "update $table_tmp_item_info_temp set item_name='$values[0]',description='$values[1]',ordered_quantity='$values[2]',unit='$unit_val[9]',vat='$values[5]',date='$today',item_id='$values[0]', sl=$unit_val[30] where mr_id='$values[4]' and item_tb_id=$values[6]";
        // echo $pr_temp_item_info_edit;
        $pr_temp_item_info_edit_q = mysql_query($pr_temp_item_info_edit);

        // $pr_temp_item_info_edit_sql= mysql_fetch_array("$pr_temp_item_info_edit_q");
        return $pr_temp_item_info_edit_q;
    }
    //mr edit from inventory user

//huawei bom search code start
    public function info3HuaweiItem($empData)
    {
        $this->Fconnection();
        $selectAlterEmployeeDataSql = mysql_query("select item_id, item_name,group_name,group_id, huwaei_id_bom_no  from all_item_info where  item_code like 'HW%' and huwaei_id_bom_no like '%$empData%' limit 25");
        // $selectAlterEmployeeDataSql = mysql_query("select per.employee_id,per.employee_name,off.designation,off.department_name,per.official_cell_no,per.official_email from tbl_personal_info as per,tbl_office_info as off where per.employee_name like '%$empData%' and per.id=off.emp_id  limit 10"); /////   Add by safa   ////////////////////////////////
        while ($allAlterEmployeeData = mysql_fetch_array($selectAlterEmployeeDataSql)) {
            $dataSet[] = $allAlterEmployeeData;
        }
        return $dataSet;
    }

    //huawei bom search code end

    //pr edit at scm end start here
    public function save_pr_info1_table_data($table_pr_info1, $pr_id)
    {
        $user_id_id = $_SESSION['employee_id'];
        $this->Fconnection();

        $mr_p0_details_sql = mysql_query("INSERT INTO `pr_info1_scm_update_purpose`( `pr_id`, `pr_type`, `pr_date`, `pr_by`, `pr_expected_date`, `pr_porpuse`, `expense_type`, `meterial_type`, `total_estimated_cost`, `delivery_instruction`, `remarks`, `status`, `date`, `user`, `license_id`, `co_id`, `pr_verify_by`, `pr_verify_date`, `pr_approve_by`, `pr_approval_date`, `uploaded_file`, `project_id`, `project_id_new`, `project_id_new_for`, `exp_description`, `update_user_id`, `datetimed`)
   SELECT  `pr_id`, `pr_type`, `pr_date`, `pr_by`, `pr_expected_date`, `pr_porpuse`, `expense_type`, `meterial_type`, `total_estimated_cost`, `delivery_instruction`, `remarks`, `status`, `date`, `user`, `license_id`, `co_id`, `pr_verify_by`, `pr_verify_date`, `pr_approve_by`, `pr_approval_date`, `uploaded_file`, `project_id`, `project_id_new`, `project_id_new_for`, `exp_description`, '$user_id_id', now() FROM `pr_info1` WHERE pr_id = '$pr_id'");
        // echo "INSERT INTO `pr_info1_temp`( `pr_id`, `pr_type`, `pr_date`, `pr_by`, `pr_expected_date`, `pr_porpuse`, `expense_type`, `meterial_type`, `total_estimated_cost`, `delivery_instruction`, `remarks`, `status`, `date`, `user`, `license_id`, `co_id`, `pr_verify_by`, `pr_verify_date`, `pr_approve_by`, `pr_approval_date`, `uploaded_file`, `project_id`, `project_id_new`, `project_id_new_for`, `exp_description`, `update_user_id`, `datetimed`)
        // SELECT  `pr_id`, `pr_type`, `pr_date`, `pr_by`, `pr_expected_date`, `pr_porpuse`, `expense_type`, `meterial_type`, `total_estimated_cost`, `delivery_instruction`, `remarks`, `status`, `date`, `user`, `license_id`, `co_id`, `pr_verify_by`, `pr_verify_date`, `pr_approve_by`, `pr_approval_date`, `uploaded_file`, `project_id`, `project_id_new`, `project_id_new_for`, `exp_description`, '$user_id_id', now() FROM `pr_info1_temp` WHERE pr_id = '$pr_id'";
        $mr_p0_info = mysql_fetch_array($mr_p0_details_sql);


        return $mr_p0_info;
    }

    public function pr_save_scm_approval_tree_table_data_save_on_scm_update($table_mr_info1, $pr_id)
    {
        $this->Fconnection();

        $mr_p0_details_sql = mysql_query("INSERT INTO `scm_approval_tree_temp_scm_update_purpose`(`pr_id`, `pr_date`, `pr_by`, `pr_approval_l1`, `pr_approval_l1_date`, `pr_approval_l2`, `pr_approval_l2_date`, `pr_approval_l3`, `pr_approval_l3_date`, `pq_id`, `pq_date`, `pq_by`, `pq_approval_l1`, `pq_approval_l1_date`, `pq_approval_l2`, `pq_approval_l2_date`, `pq_approval_l3`, `pq_approval_l3_date`, `po_id`, `po_date`, `po_by`, `po_approval_l1`, `po_approval_l1_date`, `po_approval_l2`, `po_approval_l2_date`, `po_approval_l3`, `po_approval_l3_date`, `po_approval_au_l1`, `po_approval_au_l1_date`, `po_approval_ac_l2`, `po_approval_ac_l2_date`, `po_approval_ac_l3`, `po_approval_ac_l3_date`, `flag`, `pr_31`, `pq_31`, `po_31`, `pq_forwarded_to`, `pq_forwarded_date`, `pq_forwarded2it`, `pq_forwarded2it_date`, `pq_it_st`, `pq_it_date`, `pr_forwarded_by`, `cancel_status`, `cancel_by`, `cancel_date`)
SELECT  `pr_id`, `pr_date`, `pr_by`, `pr_approval_l1`, `pr_approval_l1_date`, `pr_approval_l2`, `pr_approval_l2_date`, `pr_approval_l3`, `pr_approval_l3_date`, `pq_id`, `pq_date`, `pq_by`, `pq_approval_l1`, `pq_approval_l1_date`, `pq_approval_l2`, `pq_approval_l2_date`, `pq_approval_l3`, `pq_approval_l3_date`, `po_id`, `po_date`, `po_by`, `po_approval_l1`, `po_approval_l1_date`, `po_approval_l2`, `po_approval_l2_date`, `po_approval_l3`, `po_approval_l3_date`, `po_approval_au_l1`, `po_approval_au_l1_date`, `po_approval_ac_l2`, `po_approval_ac_l2_date`, `po_approval_ac_l3`, `po_approval_ac_l3_date`, `flag`, `pr_31`, `pq_31`, `po_31`, `pq_forwarded_to`, `pq_forwarded_date`, `pq_forwarded2it`, `pq_forwarded2it_date`, `pq_it_st`, `pq_it_date`, `pr_forwarded_by`, `cancel_status`, `cancel_by`, `cancel_date` FROM `scm_approval_tree` WHERE pr_id = '$pr_id'");

        $mr_p0_info = mysql_fetch_array($mr_p0_details_sql);


        return $mr_p0_info;
    }

    public function pr_temp_item_info_scm_update_purpose($values, $table_tmp_item_info_temp)
    {
        $this->Fconnection();
        $today = date("Y-m-d");

        $mr_p0_details_sql = mysql_query("INSERT INTO `tmp_item_info_scm_update_purpose`( `item_id`, `item_name`, `description`, `ordered_quantity`, `unit`, `price_per_unit`, `total_value`, `remarks`, `status`, `pr_id`, `date`, `vat`, `group_name`, `item_name1`, `item_id_ex`, `item_code`,item_tb_id_fk)
SELECT  `item_id`, `item_name`, `description`, `ordered_quantity`, `unit`, `price_per_unit`, `total_value`, `remarks`, `status`, `pr_id`, `date`, `vat`, `group_name`, `item_name1`, `item_id_ex`, `item_code`,item_tb_id FROM `tmp_item_info` WHERE  pr_id='$values[4]' and item_id=$values[6]");
        //echo "INSERT INTO `tmp_item_info_scm_update_purpose`( `item_id`, `item_name`, `description`, `ordered_quantity`, `unit`, `price_per_unit`, `total_value`, `remarks`, `status`, `pr_id`, `date`, `vat`, `group_name`, `item_name1`, `item_id_ex`, `item_code`,item_tb_id_fk)
//SELECT  `item_id`, `item_name`, `description`, `ordered_quantity`, `unit`, `price_per_unit`, `total_value`, `remarks`, `status`, `pr_id`, `date`, `vat`, `group_name`, `item_name1`, `item_id_ex`, `item_code`,item_tb_id FROM `tmp_item_info` WHERE  pr_id='$values[4]' and item_id=$values[6]";

        $mr_p0_info = mysql_fetch_array($mr_p0_details_sql);

        $sql = mysql_query("SELECT *  FROM  all_item_info WHERE item_id = '$values[0]'");
        // echo "SELECT *  FROM  all_item_info WHERE item_id = '$value_item_name[$i]'";
        $unit_val = mysql_fetch_row($sql);


        $pr_temp_item_info_edit = "update $table_tmp_item_info_temp set item_name='$values[0]',description='$values[1]',ordered_quantity='$values[2]',unit='$unit_val[9]',vat='$values[5]',date='$today',item_id='$values[0]' where pr_id='$values[4]' and item_tb_id=$values[7]";
        // echo $pr_temp_item_info_edit;
        $pr_temp_item_info_edit_q = mysql_query($pr_temp_item_info_edit);

        // $pr_temp_item_info_edit_sql= mysql_fetch_array("$pr_temp_item_info_edit_q");
        return $pr_temp_item_info_edit_q;

    }
    //pr edit at scm end here

    //all ipteam MR list start
    public function all_mr_ipteam_gridview($statement, $start_from, $num_rec_per_page)
    {
        $this->Fconnection();
        $sql = "SELECT mr_id,mr_type,mr_date,mr_porpuse,expense_type,meterial_type,total_estimated_cost,delivery_instruction,remarks,mr_by,license_id,co_id FROM mr_info1
     where (tbl_tier.employee_id='$val' or  tbl_tier.tr1='$val' or  tbl_tier.tr2='$val' or tbl_tier.tr3='$val' or  tbl_tier.tr4='$val' or  tbl_tier.tr5='$val') and mr_tb_id<>0
     $statement order by mr_tb_id desc";
        //echo $sql;
        $sql1 = "SELECT
  mr_info1.mr_id,
  mr_info1.mr_type,
  mr_info1.mr_date,
  mr_info1.mr_porpuse,
  mr_info1.expense_type,
  mr_info1.meterial_type,
  mr_info1.total_estimated_cost,
  mr_info1.delivery_instruction,
  mr_info1.remarks,mr_info1.mr_by,
  mr_info1.license_id,
  mr_info1.co_id,
  `mr_info1`.mr_verify_by,
  `mr_info1`.mr_verify_date,
  `mr_info1`.mr_approve_by,
  `mr_info1`.mr_approval_date,
  mr_info1.employee_to
  
FROM
  `mr_info1`
where  `mr_info1`.mr_tb_id<>0 $statement group by mr_info1.mr_id order by `mr_info1`.mr_date desc limit $start_from,$num_rec_per_page";
//echo $sql1;
        $select_mr_p0_gridview = mysql_query("$sql1");
        while ($mr_p0_gridview_list = mysql_fetch_array($select_mr_p0_gridview)) {
            $mr_p0_gridview[] = $mr_p0_gridview_list;
        }
        return $mr_p0_gridview;
    }


    public function get_all_ipteam_member()
    {
        $this->Fconnection();
        $sql = "select * from  admin_user_info where ipteam =1";
        // echo "select * from  tbl_tier_for_usage_report_16_oct where employee_id = '$em_id'";
        $grn_gen_max = mysql_query($sql);

        while ($row = mysql_fetch_assoc($grn_gen_max)) {
            $array[] = $row['employee_id'];
        }
        return $array;

    }

    //all ipteam mr list end

    public function bill_data_view_with_pq($values)
    {
        $this->Fconnection();
        $sql = "SELECT * FROM `popqpr_acc_info` WHERE `po_id` ='$values' ";
        // echo $sql;
        $insert_daily_collection_sql = mysql_query($sql);
        $pr_p0_info = mysql_fetch_array($insert_daily_collection_sql);

        return $pr_p0_info;
    }

    public function input_payment_info_new($values)
    {
        $this->Fconnection();
        $sql = "insert into popqpr_acc_info(invoice_no,money_receipt_no,client_id,date_of_collection,collection_amount,payment_type,mod_of_payment,receivable_amount,input_by,date,check_no,check_date,check_type,bank_name,po_id) values ('$values[0]','$values[1]','$values[2]','$values[3]','$values[4]','$values[5]','$values[6]','$values[7]','$values[8]','$values[9]','$values[10]','$values[11]','$values[12]','$values[13]','$values[14]')";
        // echo $sql;
        $insert_daily_collection_sql = mysql_query($sql);
        $info = mysql_insert_id();

        return $info;
    }

    public function update_payment_info_scm__app_tree($values)
    {
        $this->Fconnection();
        $sql = "update popqpr_acc_info set bill_status=$values[1],$values[2]='$values[4]',$values[3]=now() where po_id ='$values[0]'";
        // echo $sql;
        $insert_daily_collection_sql = mysql_query($sql);
        return $insert_daily_collection_sql;
    }


    public function pr_tracker_table_forword_scm($values)
    {
        $this->Fconnection();
        //echo $values;
        //$values=explode($values,',');
        $sql = "INSERT INTO `pr_tracker_table`(pr_id,$values[0]) VALUES ('$values[2]','$values[1]')";
        //echo $sql;
        $insert_into_uploded_file_sql = mysql_query("$sql");
        return $insert_into_education_sql;
    }


    public function update_pr_tracker_table_forword_scm($values)
    {
        $this->Fconnection();
        //echo $values;
        //$values=explode($values,',');
        $sql = "update`pr_tracker_table` set $values[0]='$values[1]'";
        //echo $sql;
        $insert_into_uploded_file_sql = mysql_query("$sql");
        return $insert_into_education_sql;
    }

    public function select_pr_tracker_data($table, $values)
    {
        $this->Fconnection();
        $sql = mysql_query("SELECT * FROM $table WHERE  pr_id ='$values'");
        // echo "SELECT * FROM $table WHERE  pr_id ='$values'";
        $unit_val = mysql_fetch_row($sql);
        return $unit_val;

    }

    public function add_data_saving_tracker($values)
    {
        $this->Fconnection();
        $query = "INSERT INTO tbl_savings_tracker(project_name,project_owner,projec_start_date,projec_end_date,project_description, po_number,vendor_name,category,sub_category,department,function,savings_FY,savings_category,base_line_used,savings_type,base_line_amount,final_amount,savings_amount,pr_number,attachment,user_id,created_at,project_auto_id,fh_project_name,status) VALUES ('$values[0]','$values[1]', '$values[2]','$values[3]','$values[4]','$values[5]','$values[6]','$values[7]','$values[8]','$values[9]','$values[10]','$values[11]','$values[12]','$values[13]','$values[14]','$values[15]',$values[16],$values[17],'$values[18]','$values[19]','$values[20]',now(),'$values[21]','$values[22]','$values[23]')";


        //echo $sql;
        $insert_daily_collection_sql = mysql_query($query);
        $info = mysql_insert_id();

        return $info;
    }

    public function update_saving_tracker_prev_data($val)
    {
        $this->Fconnection();
        //echo "update admin_user_info set password='$passwd',date='$date' where user_name='$val'";
        $update_chk = mysql_query("update tbl_savings_tracker set status=2 where id  ='$val'");
        return $update_chk;
    }


    public function show_savings_data($statement)
    {
        $this->Fconnection();
        $sql1 = "select * from tbl_savings_tracker where   $statement ";
        //echo $sql1;
        $select_all_item_sql1 = mysql_query("$sql1");
        while ($item_list_info1 = mysql_fetch_assoc($select_all_item_sql1)) {
            $list_item1[] = $item_list_info1;
        }
        return $list_item1;
    }


    public function saving_tracker_auto_gen_()
    {
        $this->Fconnection();
        $today = date("Y-m-d");
        $day = (explode("-", $today));
        $first_d = '2018:' . $day[1] . ':01';
        $last_d = '2018:' . $day[1] . ':31';
        $val = $_SESSION['employee_id'];
        $sql = "select * from  tbl_savings_tracker where created_at between '$first_d' and '$last_d'";

        //echo $sql;
        $mi_gen_max = mysql_query($sql);
        $mi_max_no = mysql_fetch_row($mi_gen_max);
        $a = $mi_max_no[0] + 1;
        $increment_value_mi = $today . '-' . $a;
        //echo $increment_value_mi;
        return $increment_value_mi;

    }

    public function get_single_savings_traker_data($values)
    {
        $this->Fconnection();
        $sql = mysql_query("SELECT * FROM `tbl_savings_tracker` WHERE  project_auto_id ='$values' and status < 2");
        $unit_val = mysql_fetch_row($sql);


        return $unit_val;

    }

    public function select_any_table_data($table)
    {
        $this->Fconnection();
        $sql = mysql_query("SELECT * FROM $table");
        //echo "SELECT * FROM '$table'";
        return $sql;
    }

    public function select_any_table_data_with_statement($table, $statement)
    {
        $this->Fconnection();
        $sql = mysql_query("SELECT * FROM $table $statement");
        //echo "SELECT * FROM $table $statement";
        return $sql;
    }

    //to get data site wise for infosarker report
    public function infosarkar_report_sitewise($statement, $start_from, $num_rec_per_page)
    {
        $this->Fconnection();

        //$sql1="select * from current_item_info_fainal where current_item_info_fainal.id<>0 and current_item_info_fainal.id in (select max(id) from current_item_info_fainal group by item_id)  $statement order by item_name";
        $sql1 = "SELECT * FROM `current_item_info_fainal_infosarkar` WHERE ( mi_id is not null and mi_id !='') and $statement order by id desc LIMIT $start_from, $num_rec_per_page";
        $select_all_item_sql1 = mysql_query("$sql1");
        // echo $sql1;

        return $select_all_item_sql1;

    }

    public function get_all_mr_where_rq_not_null_from_local_co($table)
    {
        $this->Fconnection();
        $sql1 = "SELECT distinct mr_id FROM $table";
        // echo $sql1;
        $grn_gen_max = mysql_query($sql1);

        while ($row = mysql_fetch_assoc($grn_gen_max)) {
            $array[] = $row['mr_id'];
        }
        return $array;

    }

    public function get_all_mr_from_mr_info1($table, $statement)
    {
        $this->Fconnection();
        $sql1 = "SELECT distinct mr_id FROM $table where mr_id not in ($statement)";
        // echo $sql1;
        $grn_gen_max = mysql_query($sql1);

        while ($row = mysql_fetch_assoc($grn_gen_max)) {
            $array[] = $row['mr_id'];
        }
        return $array;

    }

    //pr tracker final remarks func start
    public function add_final_remarks_and_attach_files($values)
    {
        $this->Fconnection();
        //echo $values;
        $sql = "UPDATE `pr_tracker_table` SET `exp_description`='$values[1]',`att_1`='$values[2]',`att_2`='$values[3]',`att_3`='$values[4]',`att_4`='$values[5]',`att_5`='$values[6]'WHERE pr_id ='$values[0]'";
        //echo $sql;
        $insert_into_uploded_file_sql = mysql_query("$sql");
        return $insert_into_uploded_file_sql;
    }

    public function update_scm_app_tree_halt_status($values)
    {
        $this->Fconnection();
        $today = date("Y-m-d");
        //$po0_sql="update scm_approval_tree set po_id='$values[0]',po_date='$values[1]',po_by='$values[2]' where pr_id='$values[3]'";
        $po0_sql = "update scm_approval_tree set pr_status =0 where pr_id='$values'";
        //echo $po0_sql;
        $po0_add_sql = mysql_query("$po0_sql");

        $insert_po0_sql = mysql_fetch_array("$po0_add_sql");
        return $insert_po0_sql;
    }

//pr tracker final remarks func end

    //payment data input start here
    public function getPoDetails($po_id)
    {
        $conn = $this->Sconnection();

        $getPoDetailsSql = mysqli_query($conn, "SELECT * FROM `scm_approval_tree` WHERE `po_id` = '$po_id'");

        while ($row = mysqli_fetch_assoc($getPoDetailsSql)) {
            $retrive[] = $row;
        }

        return $retrive;

    }

    public function fetchSingleRowScm($table, $where = NULL)
    {
        $conn = $this->Sconnection();
        $query = $this->select($table, $where, $conn);
        $results = mysqli_fetch_assoc($query);
        return $results;
    }


    public function fetchAllRows_scmv3($table, $where = NULL)
    {
        $query = $this->select_scmv3($table, $where);
        $results = $this->mysql_fetch_all_alt_scmv3($query);

        return $results;
    }

    private function mysql_fetch_all_alt_scmv3($result)
    {
        $select = array();
        while ($row = mysql_fetch_assoc($result)) {
            $select[] = $row;
        }

        return $select;
    }


    private function select_scmv3($table, $where = NULL, $conn = NULL)
    {
        if (!isset($conn)) {
            $conn = $this->Fconnection();
        }


        // print_r($where);

        $sql = "SELECT * FROM {$table}";
        // check fields if existis
        if (isset($where)) {
            $sql .= " WHERE ";
            $count = count($where);

            foreach ($where as $field => $value) {
                $sql .= "{$field}='{$value}' ";
                if ($count > 1) {
                    $sql .= " AND ";
                }
                $count--;
            }
        }


        // echo $sql;
        $query = mysql_query($sql);
        return $query;
    }


    private function select($table, $where = NULL, $conn = NULL)
    {
        if (!isset($conn)) {
            $conn = $this->Qconnection();
        }


        //print_r($where);

        $sql = "SELECT * FROM {$table}";
        // check fields if existis
        if (isset($where)) {
            $sql .= " WHERE ";
            $count = count($where);

            foreach ($where as $field => $value) {
                $sql .= "{$field}='{$value}' ";
                if ($count > 1) {
                    $sql .= " AND ";
                }
                $count--;
            }
        }


        //echo $sql;
        $query = mysqli_query($conn, $sql);
        return $query;
    }

    public function fatchProjectName($data)
    {
        $conn = $this->Sconnection();
        //echo "SELECT project_id FROM `pr_info1` WHERE `pr_id` = '$data' ";
        $fatchPayToSql = mysqli_query($conn, "SELECT project_id FROM `pr_info1` WHERE `pr_id` = '$data' ");
        $retrive = mysqli_fetch_row($fatchPayToSql);
        //echo "SELECT * FROM `project_info` WHERE `project_id` = '$retrive[0]'";
        $fatchPayToSql2 = mysqli_query($conn, "SELECT * FROM `project_info` WHERE `project_id` = '$retrive[0]'");
        $retrive2 = mysqli_fetch_assoc($fatchPayToSql2);
        return $retrive2;
    }


    public function getPoInvoiceAmount($pq_id, $pq_num)
    {
        $conn = $this->Sconnection();

        $getPoAllSql = mysqli_query($conn, "select SUM(pq_item_info.total_value) as total,pq_item_info.vat  from pq_item_info where pq_item_info.pq_id='$pq_id' and pq_number='$pq_num'");

        $retrive = mysqli_fetch_assoc($getPoAllSql);
        return $retrive;
    }


    public function fetchSingleRow($table, $where = NULL)
    {
        $query = $this->select($table, $where);
        //print_r($where);
        $results = mysqli_fetch_assoc($query);
        return $results;
    }

    /**
     * Fetch all rows
     * @param $table
     * @param null $where
     * @return array|null
     */
    public function fetchAllRows($table, $where = NULL)
    {
        $query = $this->select($table, $where);
        $results = $this->mysqli_fetch_all_alt($query);

        return $results;
    }


    private function mysqli_fetch_all_alt($result)
    {
        $select = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $select[] = $row;
        }

        return $select;
    }

    /*
     *  Add data general fnc
     */

    public function insertGeneral($tblName, $values)
    {
        $conn = $this->Qconnection();
        $key = array_keys($values);
        $value = array_values($values);
        //echo "INSERT INTO $tblName ( ". implode(',' , $key) .") VALUES('".     implode("','" , $value) ."')";
        $sql = "INSERT INTO $tblName ( " . implode(',', $key) . ") VALUES('" . implode("','", $value) . "')";

        $query = mysqli_query($conn, $sql);
        return $query;
    }

    /**
     * Fetching Employee Information by Employee ID
     * ------------------------------------------------------------
     * @param Employee id
     * @return array|null
     */
    public function fetchEmployeeDetail($empId)
    {
        $conn = $this->Qconnection();
        $sql = "SELECT * from `tbl_office_info` WHERE `employee_id` = '$empId'";
        $query = mysqli_query($conn, $sql);
        $results = mysqli_fetch_assoc($query);

        return $results;
    }

    /*
     * Update data General fnc
     */

    /**
     * Update a table, with data and where clause
     * @param $table
     * @param array $wheres
     * @param $fields
     * @return bool|mysqli_result
     */
    public function update($table, $wheres = array(), $fields)
    {
        $conn = $this->Qconnection();

        $set = '';
        $where = '';
        $count = 0;

        foreach ($wheres as $key => $value) {
            $where = " {$key} ='{$value}'";
            if (count($wheres) > 1) {
                $where .= " AND ";
            }
            $count++;
        }

        $count = 1;

        foreach ($fields as $name => $value) {
            $set .= "{$name} = '{$value}'";
            if ($count < count($fields)) {
                $set .= ", ";
            }

            $count++;
        }

        //echo "Update {$table} SET {$set} WHERE $where";
        $sql = "Update {$table} SET {$set} WHERE $where";
        $query = mysqli_query($conn, $sql);

        return $query;
    }

    //payment data end here
    //rq not done mail function start here


    public function mi_wise_rq_info_general($val)
    {
        $this->Fconnection();
        $today = date("Y-m-d");
        //$val=$_SESSION['employee_id'];
        $sql = "select mi_id,rq_id,datei from  current_item_info_fainal_local_co where mi_id='$val'  group by rq_id";
        // echo $sql;
        $select_mi_p0_gridview = mysql_query("$sql");

        return $select_mi_p0_gridview;

    }

    public function rq_not_done_mi_data_all($statement, $start_from, $num_rec_per_page)
    {
        $this->Fconnection();
        $sql1 = "SELECT * from current_item_info_fainal where id <>0 $statement LIMIT $start_from, $num_rec_per_page";
        //echo $sql1;
        $select_mr_p0_gridview_all = mysql_query("$sql1");

        return $select_mr_p0_gridview_all;

    }

    //rq not done mail function end here


    public function mr_p0_view_product_description($mr_id, $item_id)
    {
        $this->Fconnection();
        $mr_p0_details_sql = mysql_query("SELECT * FROM tmp_item_info_mr where mr_id='$mr_id' and item_id=$item_id");
        $mr_p0_info = mysql_fetch_array($mr_p0_details_sql);
        return $mr_p0_info;
    }
    //  mi wise rq start here

    //get data from current_item_info_fainal_local_co  table
    public function item_info_indv_maxid_from_local_co($rq_id, $item_id)
    {
        $this->Fconnection();
        $today = date("Y-m-d");
        //$val=$_SESSION['employee_id'];

        //$sql="select item_id,qty,max(id), from  current_item_info_fainal where item_id='$val'";
        $sql = "SELECT item_id,sum(request_qty) FROM current_item_info_fainal_local_co where rq_id='$rq_id' and item_id = $item_id";
        //if($_SESSION['employee_id']=='02-0838'){echo $sql;}
        $max = mysql_query($sql);
        $max_no = mysql_fetch_row($max);
        return $max_no;

    }

    //get data from usage table
    public function item_info_indv_maxid_from_usage_table($rq_id, $item_id)
    {
        $this->Fconnection();
        $today = date("Y-m-d");

        $sql = "SELECT value_item_name,sum(qty) FROM tbl_report_usage_02_01_2017 where rq_id='$rq_id' and value_item_name = $item_id";
        //if($_SESSION['employee_id']=='02-0629'){echo $sql;}
        $max = mysql_query($sql);
        $max_no = mysql_fetch_row($max);
        return $max_no;

    }

    public function get_last_due_value_from_usage_table($rq_id, $item_id)
    {
        $this->Fconnection();
        $today = date("Y-m-d");
        //$val=$_SESSION['employee_id'];

        //$sql="select item_id,qty,max(id), from  current_item_info_fainal where item_id='$val'";
        $sql = "SELECT * FROM tbl_report_usage_02_01_2017 where rq_id='$rq_id' and value_item_name = $item_id  ORDER BY id DESC LIMIT 1";
        //if($_SESSION['employee_id']=='02-0629'){echo $sql;}
        $max = mysql_query($sql);
        $max_no = mysql_fetch_row($max);
        return $max_no;

    }

    //mi wise rq end here

    public function get_receive_item_by_mr_rq($mr_id, $rq_id)
    {
        $conn = $this->Sconnection();

        $sql = "SELECT SUM(co.request_qty) as total_receive,co.item_id,co.item_name,co.district,co.unit,temp.description
        FROM current_item_info_fainal_local_co as co
        LEFT JOIN tmp_item_info_mr as temp ON temp.mr_id = co.mr_id and temp.item_id=co.item_id
        where co.mr_id='$mr_id' and co.rq_id='$rq_id' and co.in_out_status='1'
        GROUP BY co.item_id
        ORDER BY co.item_id ASC";

        $receive_qty = mysqli_query($conn, $sql);
        while ($row = mysqli_fetch_array($receive_qty)) {
            $receive_items[$row['item_id']] = $row;
        }
        return $receive_items;
    }

    public function get_receive_item_by_mr_rq_infosarkar($mr_id, $rq_id)
    {
        $conn = $this->Sconnection();

        $sql = "SELECT SUM(co.request_qty) as total_receive,co.item_id,co.item_name,co.district,co.unit,temp.description
        FROM current_item_info_fainal_local_co_infosarkar as co
        LEFT JOIN tmp_item_info_mr as temp ON temp.mr_id = co.mr_id and temp.item_id=co.item_id
        where co.mr_id='$mr_id' and co.rq_id='$rq_id' and co.in_out_status='1'
        GROUP BY co.item_id
        ORDER BY co.item_id ASC";
        $receive_qty = mysqli_query($conn, $sql);
        while ($row = mysqli_fetch_array($receive_qty)) {
            $receive_items[$row['item_id']] = $row;
        }
        return $receive_items;
    }

    public function get_usage_item_by_mr_rq($mr_id, $rq_id)
    {
        $conn = $this->Sconnection();
        $sql = "SELECT SUM(qty) as total_usage,value_item_name as item_id FROM tbl_report_usage_02_01_2017 where mr_id='$mr_id' and rq_id='$rq_id' and save_submit_status='1' GROUP BY item_name ORDER BY item_name ASC";
        $usage_qty = mysqli_query($conn, $sql);
        while ($row = mysqli_fetch_array($usage_qty)) {
            $usage_items[$row['item_id']] = $row;
        }
        return $usage_items;
    }

    public function get_usage_item_by_mr_rq_infosarkar($mr_id, $rq_id)
    {
        $conn = $this->Sconnection();
        $sql = "SELECT SUM(qty) as total_usage,value_item_name as item_id FROM tbl_report_usage_02_01_2017 where mr_id='$mr_id' and rq_id='$rq_id' and save_submit_status='1' GROUP BY item_name ORDER BY item_name ASC";
        $usage_qty = mysqli_query($conn, $sql);
        while ($row = mysqli_fetch_array($usage_qty)) {
            $usage_items[$row['item_id']] = $row;
        }
        return $usage_items;
    }

    public function get_returned_item_by_mr_rq($mr_id, $rq_id)
    {
        $conn = $this->Sconnection();
        $sql = "SELECT SUM(request_qty) as total_return,item_id FROM current_item_info_return_temp where mr_id='$mr_id' and rq_id='$rq_id' and return_approve_status='Accepted' GROUP BY item_name ORDER BY item_name ASC";
        $return_qty = mysqli_query($conn, $sql);
        while ($row = mysqli_fetch_array($return_qty)) {
            $return_items[$row['item_id']] = $row;
        }
        return $return_items;
    }

    public function get_returned_item_by_mr_rq_infosarkar($mr_id, $rq_id)
    {
        $conn = $this->Sconnection();
        $sql = "SELECT SUM(request_qty) as total_return,item_id FROM current_item_info_infosarkar_return_temp where mr_id='$mr_id' and rq_id='$rq_id' and return_approve_status='Accepted' GROUP BY item_name ORDER BY item_name ASC";
        $return_qty = mysqli_query($conn, $sql);
        while ($row = mysqli_fetch_array($return_qty)) {
            $return_items[$row['item_id']] = $row;
        }
        return $return_items;
    }

    public function return_item_qty($return_id)
    {
        $conn = $this->Sconnection();
        $sql = "SELECT * FROM current_item_info_return_temp where usage_return_id='$return_id'";
        $return_qty = mysqli_query($conn, $sql);
        while ($row = mysqli_fetch_array($return_qty)) {
            $return_items[$row['item_id']] = $row;
        }
        return $return_items;
    }

    public function return_item_qty_infosarkar($return_id)
    {
        $conn = $this->Sconnection();
        $sql = "SELECT * FROM current_item_info_infosarkar_return_temp where usage_return_id='$return_id'";
        $return_qty = mysqli_query($conn, $sql);
        while ($row = mysqli_fetch_array($return_qty)) {
            $return_items[$row['item_id']] = $row;
        }
        return $return_items;
    }

    public function update_temp_approval_status($return_id, $mr_id, $status)
    {
        $conn = $this->Sconnection();
        $sql = "UPDATE current_item_info_return_temp SET return_approve_status='$status' WHERE mr_id='$mr_id' and usage_return_id='$return_id'";
        $update = mysqli_query($conn, $sql);
        return $update;
    }

    public function update_temp_approval_status_infosarkar($return_id, $mr_id, $status)
    {
        $conn = $this->Sconnection();
        $sql = "UPDATE current_item_info_infosarkar_return_temp SET return_approve_status='$status' WHERE mr_id='$mr_id' and usage_return_id='$return_id'";
        $update = mysqli_query($conn, $sql);
        return $update;
    }


    public function current_item_fainal_expanse_type_on_mr($mr_id)
    {
        $this->Fconnection();
        $mr_p0_details_sql = mysql_query("SELECT * FROM current_item_info_fainal where mr_id='$mr_id' order by id desc limit 1");
        if ($_SESSION['employee_id'] == '02-0047') {
            echo "SELECT * FROM current_item_info_fainal where mr_id='$mr_id' order by id desc limit 1";
        }
        $mr_p0_info = mysql_fetch_array($mr_p0_details_sql);
        return $mr_p0_info;
    }

    /////////////////Admin/////////////////////////
    public function pr_p0_gridview_canceled($statement, $val, $start_from, $num_rec_per_page)
    {
        $this->Fconnection();
        $sql = "SELECT pr_id,pr_type,pr_date,pr_porpuse,expense_type,meterial_type,total_estimated_cost,delivery_instruction,remarks,pr_by,license_id,co_id FROM pr_info1
     where (tbl_tier.employee_id='$val' or  tbl_tier.tr1='$val' or  tbl_tier.tr2='$val' or tbl_tier.tr3='$val' or  tbl_tier.tr4='$val' or  tbl_tier.tr5='$val') and pr_tb_id<>0
     $statement order by pr_tb_id desc";
        //echo $sql;
        $sql1 = "SELECT
  pr_info1.pr_id,
  pr_info1.pr_type,
  pr_info1.pr_date,
  pr_info1.pr_porpuse,
  pr_info1.expense_type,
  pr_info1.meterial_type,
  pr_info1.total_estimated_cost,
  pr_info1.delivery_instruction,
  pr_info1.remarks,pr_info1.pr_by,
  pr_info1.license_id,
  pr_info1.co_id,
  `pr_info1`.pr_verify_by,
  `pr_info1`.pr_verify_date,
  `pr_info1`.pr_approve_by,
  `pr_info1`.pr_approval_date

FROM
  `pr_info1`,scm_approval_tree
where pr_info1.pr_id=scm_approval_tree.pr_id and scm_approval_tree.pr_id!='' and scm_approval_tree.cancel_status = 1";
//and (tbl_tier.employee_id='$val' or  tbl_tier.tr1='$val' or  tbl_tier.tr2='$val' or tbl_tier.tr3='$val' or  tbl_tier.tr4='$val' or  tbl_tier.tr5='$val' or tbl_tier.deligation='$val') and `pr_info1`.pr_tb_id<>0   $statement group by pr_info1.pr_id order by `pr_info1`.pr_tb_id desc LIMIT $start_from,$num_rec_per_page";
        echo $sql1;
        $select_pr_p0_gridview = mysql_query("$sql1");

        return $select_pr_p0_gridview;
    }

    public function auto_generated_usage_return_id($rq_id)
    {
        $this->Fconnection();
        $today = date("Y-m-d");
        $r_array = array();
        $return_id = 0;
        $sql = "select * FROM current_item_info_return_temp where rq_id='$rq_id' ORDER BY id DESC LIMIT 1";
        $rows = mysql_query($sql);
        while ($row = mysql_fetch_assoc($rows)) {
            $return_id = $row['usage_return_id'];
        }
        if ($return_id) {
            $r_array = explode("_", $return_id);
            $return_id = $r_array[2] + 1;
        } else {
            $return_id += 1;
        }
        $usage_return_id = 'R_' . $rq_id . '_' . $return_id;
        return $usage_return_id;
    }

    public function auto_generated_usage_return_id_infosarkar($rq_id)
    {
        $this->Fconnection();
        $today = date("Y-m-d");
        $r_array = array();
        $return_id = 0;
        $sql = "select * FROM current_item_info_infosarkar_return_temp where rq_id='$rq_id' ORDER BY id DESC LIMIT 1";
        $rows = mysql_query($sql);
        while ($row = mysql_fetch_assoc($rows)) {
            $return_id = $row['usage_return_id'];
        }
        if ($return_id) {
            $r_array = explode("_", $return_id);
            $return_id = $r_array[2] + 1;
        } else {
            $return_id += 1;
        }
        $usage_return_id = 'R_' . $rq_id . '_' . $return_id;
        return $usage_return_id;
    }

    public function get_return_items()
    {
        $conn = $this->Sconnection();
        $sql = "SELECT usage_return_id,mr_id,rq_id,mi_id,return_approve_status FROM current_item_info_return_temp GROUP BY usage_return_id  ORDER BY rq_id ASC, usage_return_id DESC";
        $items = mysqli_query($conn, $sql);
        while ($row = mysqli_fetch_array($items)) {
            $return_items[$row['mr_id']][$row['rq_id']][] = $row;
        }
        return $return_items;
    }


    public function get_return_items_infosarkar()
    {
        $conn = $this->Sconnection();
        $sql = "SELECT usage_return_id,mr_id,rq_id,mi_id,return_approve_status FROM current_item_info_infosarkar_return_temp GROUP BY usage_return_id  ORDER BY rq_id ASC, usage_return_id DESC";
        $items = mysqli_query($conn, $sql);
        while ($row = mysqli_fetch_array($items)) {
            $return_items[$row['mr_id']][$row['rq_id']][] = $row;
        }
        return $return_items;
    }


    public function check_return_status($return_id, $mr_id)
    {
        $conn = $this->Sconnection();
        $sql = "SELECT return_approve_status FROM current_item_info_return_temp where mr_id='$mr_id' and usage_return_id='$return_id' GROUP BY usage_return_id";
        $items = mysqli_query($conn, $sql);
        while ($row = mysqli_fetch_array($items)) {
            $check_status = $row['return_approve_status'];
        }
        return $check_status;
    }

    public function check_return_status_infosarkar($return_id, $mr_id)
    {
        $conn = $this->Sconnection();
        $sql = "SELECT return_approve_status FROM current_item_info_infosarkar_return_temp where mr_id='$mr_id' and usage_return_id='$return_id' GROUP BY usage_return_id";
        $items = mysqli_query($conn, $sql);
        while ($row = mysqli_fetch_array($items)) {
            $check_status = $row['return_approve_status'];
        }
        return $check_status;
    }


    public function gr_info_add_from_return($items)
    {
        $this->Fconnection();
        $sql = "insert into current_item_info_return_temp
        (item_tb_id,item_id,item_name,unit,sub_group,sub_group_id,`group`,group_id,
        unit_price,total_value,datei,in_out_status,user_id,mr_id,project_id,licence_id,
        expense_type,request_qty,item_code_inv,district,local_co_id,mi_id,rq_id,item_description,main_group_account,usage_return_id)
        values ('$items[item_tb_id]','$items[item_id]','$items[item_name]','$items[unit]',
        '$items[sub_group]','$items[sub_group_id]','$items[group]','$items[group_id]',
        '$items[unit_price]','$items[total_value]','$items[datei]','$items[in_out_status]',
        '$items[user_id]','$items[mr_id]','$items[project_id]','$items[licence_id]',
        '$items[expense_type]','$items[request_qty]','$items[item_code_inv]','$items[district]','$items[local_co_id]',
        '$items[mi_id]','$items[rq_id]','$items[item_description]','$items[main_group_account]','$items[usage_return_id]')";
//        $temp_gr_add_sql = mysql_query("$sql");
//        $insert_temp_gr_sql = mysql_fetch_array($temp_gr_add_sql);
//        return true;

        /*
         * From this part the return of the item is starting
         */

        $asset_list = $items['assets'];
        $somethingElse = $asset_list;
//        $find_the_rq_details = "Select * from all_item_asset_code_rq where mi_id like '' and rq_id like '' and item_asset_code like '' and status = 0";


        # Get all the Asset_codes that are selected.
        if ($asset_list != null) {
            for ($i = 0; i < count($asset_list); ++$i) {

                $find_the_rq_details = "Select * from all_item_asset_code_rq where mi_id like '$items[mi_id]' and rq_id like '$items[rq_id]' and item_asset_code like '$asset_list[$i]' and status = 0";

                $get_the_rq_details = mysql_query($find_the_rq_details);
                $get_the_rq_details_array = mysql_fetch_array($get_the_rq_details);

                if ($get_the_rq_details_array != null) {
                    $set_status_to_rq_table = "UPDATE all_item_asset_code_rq SET status = 2 WHERE id=$get_the_rq_details_array[id]";
                    // $set_status_to_rq_table_query = mysql_query($set_status_to_rq_table);

                    $insert_return_information = "
INSERT 
INTO
    all_item_asset_code_return
    (
    mi_id,
    rq_id,
    rq_table_id,
    return_id,
    item_id,
    item_asset_code,
    type,
    cable_id,
    cable_start,
    cable_end,
    cable_total,
    status
    ) 
VALUES
    (
    '$items[mi_id]',
    '$items[rq_id]',
    '$get_the_rq_details_array[id]',
    '$items[usage_return_id]',
    '$items[item_id]',
    '$asset_list[$i]',
    '$get_the_rq_details_array[type]',
    '$get_the_rq_details_array[cable_id]',
    '$get_the_rq_details_array[cable_start]',
    '$get_the_rq_details_array[cable_end]',
    '$get_the_rq_details_array[cable_total]',    
    0
    )          
                ";

//                    $insert_return_information_execution = mysql_query($insert_return_information);
                    $some = $insert_return_information;
                }

            }
        }

        return true;

    }

    public function gr_info_infosarkar_add_from_return($items)
    {
        $this->Fconnection();
        $sql = "insert into current_item_info_infosarkar_return_temp
        (item_tb_id,item_id,item_name,unit,sub_group,sub_group_id,`group`,group_id,
        unit_price,total_value,datei,in_out_status,user_id,mr_id,project_id,licence_id,
        expense_type,request_qty,item_code_inv,district,local_co_id,mi_id,rq_id,item_description,main_group_account,usage_return_id)
        values ('$items[item_tb_id]','$items[item_id]','$items[item_name]','$items[unit]',
        '$items[sub_group]','$items[sub_group_id]','$items[group]','$items[group_id]',
        '$items[unit_price]','$items[total_value]','$items[datei]','$items[in_out_status]',
        '$items[user_id]','$items[mr_id]','$items[project_id]','$items[licence_id]',
        '$items[expense_type]','$items[request_qty]','$items[item_code_inv]','$items[district]','$items[local_co_id]',
        '$items[mi_id]','$items[rq_id]','$items[item_description]','$items[main_group_account]','$items[usage_return_id]')";
        $temp_gr_add_sql = mysql_query("$sql");
        $insert_temp_gr_sql = mysql_fetch_array($temp_gr_add_sql);
        return true;
    }

    public function insert_item_to_current_fainal($r_items, $gr_id)
    {

        $this->Fconnection();
        foreach ($r_items as $items) {
            mysql_query("UPDATE current_item_info_return_temp SET item_description='$items[item_description]' WHERE usage_return_id='$items[usage_return_id]' and item_id='$items[item_id]'");

            $sql = "SELECT qty FROM current_item_info_fainal WHERE item_id='$items[item_id]' order by id desc limit 1";
            $sql_data = mysql_query("$sql");
            $data = mysql_fetch_array($sql_data);
            $previous_qty = $data['qty'];
            $current_qty = $data['qty'] + $items['request_qty'];
            $sql = "insert into current_item_info_fainal
            (item_tb_id,item_id,item_name,qty,unit,sub_group,sub_group_id,`group`,group_id,
            unit_price,total_value,datei,in_out_status,user_id,mr_id,project_id,licence_id,
            expence_type,gr_id,mi_id,request_qty,previous_qty,item_code_inv,district,local_co_id,
            main_group_account,rq_id,item_description)
            values ('$items[item_tb_id]','$items[item_id]','$items[item_name]','$current_qty','$items[unit]',
            '$items[sub_group]','$items[sub_group_id]','$items[group]','$items[group_id]',
            '$items[unit_price]','$items[total_value]','$items[datei]','$items[in_out_status]',
            '$items[user_id]','$items[mr_id]','$items[project_id]','$items[licence_id]',
            '$items[expense_type]','$gr_id','$items[mi_id]','$items[request_qty]','$previous_qty','$items[item_code_inv]',
            '$items[district]','$items[local_co_id]','$items[main_group_account]','$items[rq_id]',
            '$items[item_description]')";
            $temp_gr_add_sql = mysql_query("$sql");
            $insert_sql = mysql_fetch_array($temp_gr_add_sql);
        }
        return true;
    }

    public function insert_item_to_current_fainal_infosarkar($r_items, $gr_id)
    {

        $this->Fconnection();
        foreach ($r_items as $items) {
            mysql_query("UPDATE current_item_info_infosarkar_return_temp SET item_description='$items[item_description]' WHERE usage_return_id='$items[usage_return_id]' and item_id='$items[item_id]'");

            $sql = "SELECT qty FROM current_item_info_fainal_infosarkar WHERE item_id='$items[item_id]' order by id desc limit 1";
            $sql_data = mysql_query("$sql");
            $data = mysql_fetch_array($sql_data);
            $previous_qty = $data['qty'];
            $current_qty = $data['qty'] + $items['request_qty'];
            $sql = "insert into current_item_info_fainal_infosarkar
            (item_tb_id,item_id,item_name,qty,unit,sub_group,sub_group_id,`group`,group_id,
            unit_price,total_value,datei,in_out_status,user_id,mr_id,project_id,licence_id,
            expence_type,gr_id,mi_id,request_qty,previous_qty,item_code_inv,district,local_co_id,
            main_group_account,rq_id,item_description)
            values ('$items[item_tb_id]','$items[item_id]','$items[item_name]','$current_qty','$items[unit]',
            '$items[sub_group]','$items[sub_group_id]','$items[group]','$items[group_id]',
            '$items[unit_price]','$items[total_value]','$items[datei]','$items[in_out_status]',
            '$items[user_id]','$items[mr_id]','$items[project_id]','$items[licence_id]',
            '$items[expense_type]','$gr_id','$items[mi_id]','$items[request_qty]','$previous_qty','$items[item_code_inv]',
            '$items[district]','$items[local_co_id]','$items[main_group_account]','$items[rq_id]',
            '$items[item_description]')";
            $temp_gr_add_sql = mysql_query("$sql");
            $insert_sql = mysql_fetch_array($temp_gr_add_sql);
        }
        return true;
    }


    public function gr_auto_gen_for_return()
    {
        $this->Fconnection();
        $today = date("Y-m-d");
        //$val=$_SESSION['employee_id'];
        $sql = "select max(id) from  current_item_info_fainal";
        //echo $sql;
        $grn_gen_max = mysql_query($sql);
        $grn_max_no = mysql_fetch_row($grn_gen_max);
        $a = $grn_max_no[0] + 1;
        $increment_value_grn = 'FAHSC' . $today . 'IGR' . $a;
        return $increment_value_grn;

    }

    public function gr_auto_gen_for_return_infosarkar()
    {
        $this->Fconnection();
        $today = date("Y-m-d");
        $val = $_SESSION['employee_id'];
        $sql = "select max(id) from  current_item_info_fainal_infosarkar";
        //echo $sql;
        $grn_gen_max = mysql_query($sql);
        $grn_max_no = mysql_fetch_row($grn_gen_max);
        $a = $grn_max_no[0] + 1;
        $increment_value_grn = 'FAHINFO3' . $val . $today . 'IGR' . $a;
        return $increment_value_grn;
    }

    public function get_supply_chain_employees()
    {
        $results = array();
        $conn = $this->Sconnection();
        $sql = "SELECT employee_id,employee_name FROM tbl_office_info where employee_id in (select pr_approval_l3 as employee_id from scm_approval_tree where employee_id!='' and employee_id!='02-0047' group by employee_id)";
        $employees = mysqli_query($conn, $sql);
        while ($row = mysqli_fetch_array($employees)) {
            $results[] = $row;
        }
        return $results;
    }


}//end model class
?>