<?php

namespace TCG\Voyager\Listeners;

use TCG\Voyager\Events\BreadAdded;
use TCG\Voyager\Facades\Voyager;

class AddBreadPermission
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Create Permission for a given BREAD.
     *
     * @param BreadAdded $event
     *
     * @return void
     */
    public function handle(BreadAdded $bread)
    {
        if (config('voyager.bread.add_permission') && file_exists(base_path('routes/web.php'))) {
            // Create permission
            //
            // Permission::generateFor(Str::snake($bread->dataType->slug));
            $role = Voyager::model('Role')->where('name', config('voyager.bread.default_role'))->firstOrFail();

            // Get permission for added table
            $permissions = Voyager::model('Permission')->where(['table_name' => $bread->dataType->name])->get()->pluck('id')->all();

            // get exsisting permissions of this role
            $exsistingPermissions = $role->permissions->pluck('id')->all();

            // get new permissions
            $permissions = array_values(array_diff($permissions, $exsistingPermissions));

            // Assign permission to admin
            $role->permissions()->attach($permissions);
        }
    }
}
