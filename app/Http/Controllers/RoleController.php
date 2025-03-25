<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;


class RoleController extends Controller //role controller for roles
{
    public function index(){
        try{
            $roles = Role::all(); //fetch all roles

            if($roles->count()>0){ //check if roles exist
        return response()->json([ $roles], 200); //return roles
        } else {
            return "No roles found"; //return if no roles found
        }
    } catch(\Exception $e) {
        return response()->json([ "Error fetching roles"], 500) ; //return if error fetching roles
    }
}
public function createRole(Request $request){
    $validated = $request->validate([
        'name' => 'required|string|max:255|unique:roles',
        'slug' => 'required|string|max:255|unique:roles',
        'description' => 'nullable|string|max:1000',
    ]);

    try{
        $role = new Role();
        $role->name=$request->name;
        $role->slug=$request->slug;
        $role->description=$request->description;
        if ($role){
            return "Role created successfully";
    }
    else{
        return response()->json(['error' => "Error creating role"], 500);
    }
}
catch(\Exception $e){
    return response()->json(['error' => "Error creating role"], 500);
}
}
public function getRole($id){
try{
    $role = Role::findOrFail($id);
    if($role){
        return response()->json([$role],200);
    }
    else{
        return "Role not found for ID:$id";
    }
}
catch(\Exception $e){
    return response()->json(["Error fetching role $e"],404);  }
}
public function updateRole(Request $request, $id){
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'slug' => 'required|string|max:255',
        'description' => 'nullable|string|max:1000',
    ]);
    $roleToUpdate = Role::findorFail($id);

    if($roleToUpdate){
       $roleToUpdate->name = $request->name;
       $roleToUpdate->slug = $request->slug;
       $roleToUpdate->description = $request->description;
       try{
       $updatedRole = $roleToUpdate->save();

          if ($updatedRole){
        return response()->json(["Updated Role",$roleToUpdate],20
          );
    }
    else{
        return "Role not found for ID:$id";
    }
    }
    catch(\Exception $e){
        return response()->json(["Error updating role $e"],404);
    }
}
}
public function deleteRole($id){
    try {
        $roleToDelete = Role::findorFail($id);
        if($roleToDelete) {
            try {
            $deletedRole=Role::destroy($id);
            if($deletedRole){
            return "Role deleted successfully";
        }
        else{
            return "Role was not deleted";

            }

    } catch(\Exception $e) {
        return response()->json(["Role not found $e"], 
        404);
    }
}
} catch(\Exception $e) {
    return response()->json(["Error deleting role $e"], 500);
}
}
}



