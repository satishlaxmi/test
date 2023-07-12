<?php
    use Illuminate\Support\Facades\DB;
    use App\Models\User;

    function getReciverName($satish){
       
    $names= User::where('id',$satish)->get()->first();
    return $names->name;

    

    }

    function getSenderName($satish){
        $names= User::where('id',$satish)->get()->first();  
        return $names->name;

        }
    


?>