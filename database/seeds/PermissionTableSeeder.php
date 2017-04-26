<?php

use App\Role;
use Illuminate\Database\Seeder;
use App\Permission;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permission = [

            /*Role Permissions*/
            [
                'name' => 'role-list',
                'display_name' => 'Display Role Listing',
                'description' => 'See only Listing Of Role'
            ],
            [
                'name' => 'role-create',
                'display_name' => 'Create Role',
                'description' => 'Create New Role'
            ],
            [
                'name' => 'role-edit',
                'display_name' => 'Edit Role',
                'description' => 'Edit Role'
            ],
            [
                'name' => 'role-delete',
                'display_name' => 'Delete Role',
                'description' => 'Delete Role'
            ],

            /*User Permissions*/
            [
                'name' => 'user-list',
                'display_name' => 'Display User Listing',
                'description' => 'See only Listing Of User'
            ],
            [
                'name' => 'user-create',
                'display_name' => 'Create User',
                'description' => 'Create New User'
            ],
            [
                'name' => 'user-edit',
                'display_name' => 'Edit User',
                'description' => 'Edit User'
            ],
            [
                'name' => 'user-delete',
                'display_name' => 'Delete User',
                'description' => 'Delete User'
            ],
            [
                'name' => 'user-ban',
                'display_name' => 'Ban User',
                'description' => 'Ban User'
            ],
            [
                'name' => 'user-suspend',
                'display_name' => 'Suspend User',
                'description' => 'Suspend User'
            ],

            /*Ads Permissions*/
            [
                'name' => 'ad-list',
                'display_name' => 'Display Ad',
                'description' => 'Display Ad'
            ],
            [
                'name' => 'ad-create',
                'display_name' => 'Create Ad',
                'description' => 'Create Ad'
            ],
            [
                'name' => 'ad-delete',
                'display_name' => 'Delete Ad',
                'description' => 'Delete Ad'
            ],


            /*Realhomz Permissions*/
            [
                'name' => 'home-list',
                'display_name' => 'Display Realhomz Home',
                'description' => 'Display Realhomz Home'
            ],
            [
                'name' => 'home-create',
                'display_name' => 'Create Realhomz Home',
                'description' => 'Create Realhomz Home'
            ],
            [
                'name' => 'home-edit',
                'display_name' => 'Edit Realhomz Home',
                'description' => 'Edit Realhomz Home'
            ],
            [
                'name' => 'home-delete',
                'display_name' => 'Delete Realhomz Home',
                'description' => 'Delete Realhomz Home'
            ],
            /*************************/
            [
                'name' => 'rental-list',
                'display_name' => 'Display Realhomz Rental',
                'description' => 'Display Realhomz Rental'
            ],
            [
                'name' => 'rental-create',
                'display_name' => 'Create Realhomz Rental',
                'description' => 'Create Realhomz Rental'
            ],
            [
                'name' => 'rental-edit',
                'display_name' => 'Edit Realhomz Rental',
                'description' => 'Edit Realhomz Rental'
            ],
            [
                'name' => 'rental-delete',
                'display_name' => 'Delete Realhomz Rental',
                'description' => 'Delete Realhomz Rental'
            ],
            /*************************/
            [
                'name' => 'plot-list',
                'display_name' => 'Display Realhomz Plot',
                'description' => 'Display Realhomz Plot'
            ],
            [
                'name' => 'plot-create',
                'display_name' => 'Create Realhomz Plot',
                'description' => 'Create Realhomz Plot'
            ],

            [
                'name' => 'plot-delete',
                'display_name' => 'Delete Realhomz Plot',
                'description' => 'Delete Realhomz Plot'
            ],
            [
                'name' => 'plot-edit',
                'display_name' => 'Edit Realhomz Plot',
                'description' => 'Edit Realhomz Plot'
            ],

                /*Posts Permissions*/
            [
            'name' => 'post-like',
            'display_name' => 'Like Dream House',
            'description' => 'Like Dream house on the home page and in people\'s projects'
            ],
            [
                'name' => 'post-drim',
                'display_name' => 'Drim a house',
                'description' => 'Drim a house on the home page and in people\'s projects'
            ],
            [
                'name' => 'post-follow',
                'display_name' => 'Follow a house',
                'description' => 'Follow a house on the home page and in people\'s projects'
            ],
            [
                'name' => 'user-follow',
                'display_name' => 'Follow a user',
                'description' => 'Follow a user on the home page and in people\'s projects'
            ],
            [
                'name' => 'expert-rate',
                'display_name' => 'Rate an expert',
                'description' => 'Rate an expert'
            ],
            [
                'name' => 'comment-create',
                'display_name' => 'Comment on a house/question/article',
                'description' => 'Comment on a house on the home page and in people\'s projects'
            ],
            [
                'name' => 'comment-edit',
                'display_name' => 'Edit a comment',
                'description' => 'Edit a comment on the home page and in people\'s projects'
            ],
            [
                'name' => 'comment-delete',
                'display_name' => 'Delete a comment',
                'description' => 'Delete a comment on the home page and in people\'s projects'
            ],

            /*Shop Permissions*/
            [
                'name' => 'shop-list',
                'display_name' => 'Display Shop',
                'description' => 'Display Shop'
            ],
            [
                'name' => 'shop-create',
                'display_name' => 'Create Shop',
                'description' => 'Create Shop'
            ],

            [
                'name' => 'shop-edit',
                'display_name' => 'Edit Shop',
                'description' => 'Edit Shop'
            ],
            [
                'name' => 'shop-delete',
                'display_name' => 'Delete  Shop',
                'description' => 'Delete Shop'
            ],

            /*************************/
            [
                'name' => 'product-list',
                'display_name' => 'Display Product',
                'description' => 'Display Shop Product'
            ],
            [
                'name' => 'product-create',
                'display_name' => 'Create Product',
                'description' => 'Create Shop Product'
            ],

            [
                'name' => 'product-edit',
                'display_name' => 'Edit Product',
                'description' => 'Edit Shop Product'
            ],
            [
                'name' => 'product-delete',
                'display_name' => 'Delete Product',
                'description' => 'Delete Shop Product'
            ],
            /*Advice Permissions*/
            [
                'name' => 'question-list',
                'display_name' => 'Display Question',
                'description' => 'Display Question'
            ],
            [
                'name' => 'question-create',
                'display_name' => 'Create Question',
                'description' => 'Create Question'
            ],
            [
                'name' => 'question-edit',
                'display_name' => 'Edit Question',
                'description' => 'Edit Question'
            ],
            [
                'name' => 'question-delete',
                'display_name' => 'Delete  Question',
                'description' => 'Delete Question'
            ],

            /*************************/
            [
                'name' => 'article-list',
                'display_name' => 'Display Article',
                'description' => 'Display Article'
            ],
            [
                'name' => 'article-create',
                'display_name' => 'Create Article',
                'description' => 'Create Article'
            ],
            [
                'name' => 'article-edit',
                'display_name' => 'Edit Article',
                'description' => 'Edit Article'
            ],
            [
                'name' => 'article-delete',
                'display_name' => 'Delete  Article',
                'description' => 'Delete Article'
            ],

            /*Expert Permissions*/
            [
                'name' => 'expert-list',
                'display_name' => 'Display Expert',
                'description' => 'Display Expert'
            ],
            [
                'name' => 'skill-create',
                'display_name' => 'Create Skill',
                'description' => 'Create Skill'
            ],
            [
                'name' => 'skill-edit',
                'display_name' => 'Edit Skill',
                'description' => 'Edit Skill'
            ],
            [
                'name' => 'skill-delete',
                'display_name' => 'Delete Skill',
                'description' => 'Delete Skill'
            ],
        ];
        $role = Role::where('name','super');
        foreach ($permission as $key => $value) {
            Permission::create($value);
        }
        $permission = Permission::get();
        $role->attachPermissions($permission);


    }
}
