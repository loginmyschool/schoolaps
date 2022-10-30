<?
namespace WTOS\Helpers;
global $os, $site;
class AdminAccess{
    var $os, $site;
    public function __construct($os, $site)
    {
        $this->os=$os;
        $this->site=$site;
    }

    public function get_menu($admin){
        $adminId=$admin["adminId"];
        $isSuperAdmin=$admin["adminType"]=="Super Admin";

        $sql = "SELECT am.* FROM admin_menu am INNER JOIN admin_access aa on am.access_key = aa.access_key AND aa.adminId='$adminId' AND am.only_super_admin!='Yes'";
        if ($isSuperAdmin){
            $sql = "SELECT * FROM admin_menu WHERE active_status='Active'";
        }
        $query = $this->os->mq($sql);
        $menu=[];
        while ($item = $this->os->mfa($query)){
            $menu[$item['parent_admin_menu_id']][$item['admin_menu_id']] = $item;

        }
        return $menu;
    }
    public function get_accesses($admin){
        $adminId=$admin["adminId"];
        $isSuperAdmin= ($admin["adminType"]=="Super Admin");

        $sql = "SELECT am.* FROM admin_menu am INNER JOIN admin_access aa on am.access_key = aa.access_key AND aa.adminId='$adminId'";
        if ($isSuperAdmin){
            $sql = "SELECT * FROM admin_menu WHERE active_status='Active'";
        }
        //print $sql;
        $query = $this->os->mq($sql);
        $menu=[];
        while ($item = $this->os->mfa($query)){
            $menu[] = $item['access_key'];

        }
        return $menu;


    }
    public function get_branches($access_key, $admin='', $full=false){
        $adminId=$admin["adminId"];
        $isSuperAdmin= ($admin["adminType"]=="Super Admin");


        $sql = "SELECT b.* FROM branch b 
                INNER JOIN admin_access_branch aab ON aab.branch_code=b.branch_code AND aab.access_key='$access_key' AND aab.adminId='$adminId'
                WHERE  b.active_status='Active'";
        if ($isSuperAdmin){
            $sql = "SELECT * FROM branch WHERE active_status='Active'";
        }

        $query = $this->os->mq($sql);
        $menu=[];
        while ($item = $this->os->mfa($query)){
            $menu[$item["branch_code"]] = $full?$item:$item['branch_name'];
        }
        return $menu;
    }
    public function get_classess($access_key, $branch_code, $admin){
        $adminId=$admin["adminId"];
        $isSuperAdmin= ($admin["adminType"]=="Super Admin");

        $res=[];

        foreach ($this->os->classList as $class=>$val){
            $res[$class] = "";
        }

        if($isSuperAdmin){
            return $res;
        }


        $sql = "SELECT * FROM admin_access_class aac WHERE aac.access_key = '$access_key' AND aac.adminId='$adminId' AND aac.branch_code='$branch_code'";
        $query = $this->os->mq($sql);
        $res = [];
        while ($item = $this->os->mfa($query)){
            $res[$item['class']] = $item['gender'];
        }
        return $res;
    }
    public function get_secondary_access($access_key, $branch_code, $admin){
        $adminId=$admin["adminId"];
        $isSuperAdmin= ($admin["adminType"]=="Super Admin");

        $raw = $this->os->mfa($this->os->mq("SELECT  am.second_level_access, aab.secondary_accesses FROM admin_menu am 
            LEFT JOIN admin_access_branch aab ON  aab.adminId='$adminId' AND aab.branch_code='$branch_code' AND aab.access_key=am.access_key 
            WHERE am.access_key = '$access_key'"));

        if($isSuperAdmin){
            $res = (array)@explode(",",@$raw["second_level_access"]);
        } else {
            $res = (array)@json_decode(@$raw["secondary_accesses"]);
        }

        return array_filter($res);
    }
    public function get_global_access($access_key, $admin){
        $adminId=$admin["adminId"];
        $isSuperAdmin= ($admin["adminType"]=="Super Admin");

        $res=[];



        $raw = $this->os->mfa($this->os->mq("SELECT  am.global_accesses, aa.secondary_access FROM admin_menu am 
            LEFT JOIN admin_access aa ON  aa.adminId='$adminId'  AND aa.access_key=am.access_key 
            WHERE am.access_key = '$access_key'"));

        if($isSuperAdmin){
            $res = explode(",",@$raw["second_level_access"]);
        } else {
            $res = explode(",",@$raw["secondary_access"]);
        }

        return array_filter($res);
    }

}
?>
