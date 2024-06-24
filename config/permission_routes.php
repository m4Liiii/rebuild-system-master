<?php

return [
    'routes' => [
        'users.index' => 'show_user',
        'users.create' => 'create_user',
        'users.store' => 'create_user',
        'users.edit' => 'edit_user',
        'users.update' => 'edit_user',
        'users.destroy' => 'delete_user',


        'roles.index' => 'show_role',
        'roles.create' => 'create_role',
        'roles.store' => 'create_role',
        'roles.edit' => 'edit_role',
        'roles.update' => 'edit_role',
        'roles.destroy' => 'delete_role',


        'categories.index' => 'show_category',
        'categories.create' => 'create_category',
        'categories.store' => 'create_category',
        'categories.edit' => 'edit_category',
        'categories.update' => 'edit_category',
        'categories.destroy' => 'delete_category',


        'product.show' => 'show_product',
        'fix.product' => 'edit_product',
        'categories.products.index' => 'show_product',
        'categories.products.create' => 'create_product',
        'categories.products.store' => 'create_product',
        'categories.products.edit' => 'edit_product',
        'categories.products.update' => 'edit_product',
        'categories.products.destroy' => 'delete_product',


        'customers.index' => 'show_customer',
        'customers.create' => 'create_customer',
        'customers.store' => 'create_customer',
        'customers.edit' => 'edit_customer',
        'customers.update' => 'edit_customer',
        'customers.destroy' => 'delete_customer',


        'customers.getdebts.index' => 'show_getdebt',
        'customers.getdebts.create' => 'create_getdebt',
        'customers.getdebts.store' => 'create_getdebt',
        'customers.getdebts.edit' => 'edit_getdebt',
        'customers.getdebts.update' => 'edit_getdebt',
        'customers.getdebts.destroy' => 'delete_getdebt',


        'before.create.invoice' => 'create_getdebt',
        'before.store.invoice' => 'create_getdebt',
        'getdebts.invoices.index' =>'edit_getdebt',
        'list.invoice' => 'show_getdebt',
        'list.invoice.all' => 'show_getdebt',
        'list.invoice.customer' => 'show_getdebt',

        'offices.index' => 'show_office',
        'offices.create' => 'create_office',
        'offices.store' => 'create_office',
        'offices.edit' => 'edit_office',
        'offices.update' => 'edit_office',
        'offices.destroy' => 'delete_office',


       'offices.offdebts.index' => 'show_offdebt',
       'offices.offdebts.create' => 'create_offdebt',
       'offices.offdebts.store' => 'create_offdebt',
       'offices.offdebts.edit' => 'edit_offdebt',
       'offices.offdebts.update' => 'edit_offdebt',
       'offices.offdebts.destroy' => 'delete_offdebt',


       'debtors.index' => 'show_debtor',
       'debtors.create' => 'create_debtor',
       'debtors.store' => 'create_debtor',
       'debtors.edit' => 'edit_debtor',
       'debtors.update' => 'edit_debtor',
       'debtors.destroy' => 'delete_debtor',


       'debtors.onlydebts.index' => 'show_onlydebt',
       'debtors.onlydebts.create' => 'create_onlydebt',
       'debtors.onlydebts.store' => 'create_onlydebt',
       'debtors.onlydebts.edit' => 'edit_onlydebt',
       'debtors.onlydebts.update' => 'edit_onlydebt',
       'debtors.onlydebts.destroy' => 'delete_onlydebt',



       'sellers.index' => 'show_seller',
       'sellers.create' => 'create_seller',
       'sellers.store' => 'create_seller',
       'sellers.edit' => 'edit_seller',
       'sellers.update' => 'edit_seller',
       'sellers.destroy' => 'delete_seller',


        ]
];
