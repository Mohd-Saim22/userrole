<?php
namespace App\Repositories;

use App\Models\User;
use App\Models\Role;
use App\Models\Permission;
use Illuminate\Support\Facades\Gate;
use \Exception;

class UserRepository
{
    /**
     * Returns the users list with Loading Relation
     *
     * @author Manojkiran.A <manojkiran10031998@gmail.com>
     * @return array
     **/
    public function showRecords(): array
    {
        abort_if(Gate::denies('user_access'),403);

        $usersList = User::latest()
                        ->with(['roles','permissions'])
                        ->excludeRootUser()
                        ->paginate(null, ['*'], 'userPage')
                        ->onEachSide(2);

        $returnables = compact('usersList');

        return $returnables;
    }

    /**
     * Return the required data that needs to be 
     * Displayed While Creating the new Record
     *
     * @author Manojkiran.A <manojkiran10031998@gmail.com>
     * @return array
     **/
    public function createRecord(): array
    {
        abort_if(Gate::denies('user_create'), 403);
        
        $roleList = Role::excludeRootRole()
                        ->pluckWithPlaceHolder('name', 'id', 'Choose Role');
        
        $permissionList = Permission::pluckWithPlaceHolder('name', 'id', 'Choose Permissions');

        $returnables = compact('roleList', 'permissionList');

        return $returnables;        
    }

    /**
     * Store the New User into Database
     *
     * @author Manojkiran.A <manojkiran10031998@gmail.com>
     * @param \App\Http\Requests\UserStoreRequest $request
     * @return \App\Models\User
     **/
    public function storeRecord($request): User
    {
        $user = User::create($request->all());

        $user->syncRoles($request->input('roles', []));

        $user->syncPermissions($request->input('permissions', []));

        return $user;
    }

    /**
     * Shows the Specific Record
     *
     * @author  Manojkiran.A <manojkiran10031998@gmail.com>
     * @param   \App\Models\User $user
     * @return  array
     **/
    public function showRecord($user): array
    {
        abort_if(Gate::denies('user_show') || $user->isRoot(), 403);

        $relationCallBack = function ($query) {
            $query->select('id', 'name');
        };

        $user = $user->load(['roles' => $relationCallBack,'permissions' => $relationCallBack]);

        $returnables = compact('user');

        return $returnables;

    }

    /**
     * Return the Required Data that is required 
     * for editing the user
     *
     * @author  Manojkiran.A <manojkiran10031998@gmail.com>
     * @param   \App\Models\User $user
     * @return  array
     **/
    public function editRecord($user): array
    {
        abort_if(Gate::denies('user_edit') || $user->isRoot(),403);

        $roleList = Role::excludeRootRole()
                        ->pluckWithPlaceHolder('name', 'id', 'Choose Role');
        $permissionList = Permission::pluckWithPlaceHolder('name', 'id', 'Choose Permissions');

        $returnables = compact('roleList', 'permissionList', 'user');;

        return $returnables;
    }

    /**
     * Update the User With Current Request
     *
     * @author  Manojkiran.A <manojkiran10031998@gmail.com>
     * @param   \App\Http\Requests\UserStoreRequest $request
     * @param   \App\Models\User $user
     * @return  \App\Models\User
     **/
    public function updateRecord($request,$user): User
    {
        abort_if($user->isRoot(), 403);

        $user->update($request->all());

        $user->syncRoles($request->input('roles', []));

        $user->syncPermissions($request->input('permissions', []));

        return $user;
    }

    /**
     * Deletes the User Record
     *
     * @author  Manojkiran.A <manojkiran10031998@gmail.com>
     * @param   \App\Models\User $user
     * @throws \Exception
     * @return void
     **/
    public function removeRecord($user)
    {
        abort_if(Gate::denies('user_delete') || $user->isRoot(), 403);
        $user->roles()->detach();
        $user->delete();
    }
    

    /**
     * Gets all the SoftDeleted Model
     * from Database
     * 
     * @author Manojkiran.A <manojkiran10031998@gmail.com>
     * @return array
     **/
    public function showDeletedRecords(): array
    {
        abort_if(Gate::denies('user_deleted_access'), 403);

        $usersList = User::onlyTrashed()
                        ->latest()
                        ->paginate(null, ['*'], 'userDeletedPage')
                        ->onEachSide(2);

        $returnables = compact('usersList');

        return $returnables;
    }

    /**
     * Deletes the Soft Deleted Model
     *
     * @author  Manojkiran.A <manojkiran10031998@gmail.com>
     * @param   \App\Models\User $user
     * @return  void
     **/
    public function deleteRecord($user): void
    {
        abort_if(Gate::denies('user_force_delete'), 403);

        $user-> forceDelete();
    }

    /**
     * Deletes the Soft Deleted Model
     *
     * @author  Manojkiran.A <manojkiran10031998@gmail.com>
     * @param   \App\Models\User $user
     * @return  void
     **/
    public function restoreRecord($user): void
    {
        abort_if(Gate::denies('user_restore'), 403);

        $user-> restore();
    }
}
