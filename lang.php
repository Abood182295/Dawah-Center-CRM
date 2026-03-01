<?php
session_start();

if (!isset($_SESSION['lang'])) {
    $_SESSION['lang'] = 'ar';
}

if (isset($_GET['lang'])) {
    $_SESSION['lang'] = $_GET['lang'];
    header("Location: " . strtok($_SERVER['REQUEST_URI'], '?'));
    exit();
}

$lang = $_SESSION['lang'];

$translations = [
    'en' => [
        'title' => 'Association CRM',
        'welcome' => 'Welcome, Abdullah. Select an action below:',
        'add_cust' => 'Add Customer',
        'add_desc' => 'Register new visitor numbers',
        'view_db' => 'View Database',
        'view_desc' => 'Search and manage lists',
        'send_msg' => 'Send Messages',
        'coming_soon' => '(Coming Soon...)',
        'switch' => 'العربية',
        'actions' => 'Actions',
        'edit' => 'Edit',
        'delete' => 'Delete',
        'update_header' => 'Update Customer Info',
        'confirm_delete' => 'Are you sure you want to delete this customer?',
        'broadcast_header' => 'Send Broadcast Message',
        'select_cat' => 'Select Category to Message',
        'msg_placeholder' => 'Type your offer message here...',
        'send_btn' => 'Send to All',
        'count_label' => 'Total customers in this category: ',
        'preview_header' => 'Mobile Preview',
        'search_placeholder' => 'Search by name or number...',
        'filter_btn' => 'Search',
        'all_cats' => 'All Categories',
        'btn_print' => 'Print Report',
        'edit_title' => 'Edit Customer Information',
        'update_btn' => 'Update Record',
        'success_update' => 'Customer updated successfully!',
        'date' => 'Registration Date',
        'import_title' => 'Import Customers from CSV',
        'select_file' => 'Select CSV File',
        'btn_upload' => 'Upload and Import',
        'import_success' => 'Records imported successfully!',
        'import_error' => 'Error importing data. Please check the file format.',
        'btn_export' => 'Export to Excel',
        // Form & Table
        'reg_header' => 'Register New Customer',
        'lbl_name' => 'Full Name',
        'lbl_phone' => 'Phone Number',
        'lbl_cat' => 'Category',
        'btn_save' => 'Save to Database',
        'opt_gen' => 'General',
        'opt_off' => 'Offers',
        'opt_vln' => 'Volunteer',
        'opt_dawah' => 'Dawah',
        'back' => 'Back to Dashboard',
        'date' => 'Registration Date'
    ],
    'ar' => [
        'title' => 'نظام إدارة العملاء',
        'welcome' => 'مرحباً عبدالله، اختر إجراءً مما يلي:',
        'add_cust' => 'إضافة عميل',
        'add_desc' => 'تسجيل أرقام الزوار الجدد',
        'view_db' => 'عرض القاعدة',
        'view_desc' => 'البحث وإدارة القوائم',
        'send_msg' => 'إرسال رسائل',
        'coming_soon' => '(قريباً...)',
        'switch' => 'English',
        'actions' => 'الإجراءات',
        'edit' => 'تعديل',
        'delete' => 'حذف',
        'update_header' => 'تحديث معلومات العميل',
        'confirm_delete' => 'هل أنت متأكد أنك تريد حذف هذا العميل؟',
        'broadcast_header' => 'إرسال رسالة جماعية',
        'select_cat' => 'اختر الفئة المستهدفة',
        'msg_placeholder' => 'اكتب نص العرض هنا...',
        'send_btn' => 'إرسال للكل',
        'count_label' => 'إجمالي العملاء في هذه الفئة: ',
        'preview_header' => 'معاينة الهاتف',
        'search_placeholder' => 'ابحث بالاسم أو الرقم...',
        'filter_btn' => 'بحث',
        'all_cats' => 'كل الفئات',
        'btn_print' => 'طباعة التقرير',
        'edit_title' => 'تعديل بيانات العميل',
        'update_btn' => 'تحديث البيانات',
        'success_update' => 'تم تحديث بيانات العميل بنجاح!',
        'date' => 'تاريخ التسجيل',
        'import_title' => 'استيراد العملاء من ملف CSV',
        'select_file' => 'اختر ملف CSV',
        'btn_upload' => 'رفع واستيراد',
        'import_success' => 'تم استيراد البيانات بنجاح!',
        'import_error' => 'خطأ في استيراد البيانات. يرجى التحقق من صيغة الملف.',
        'btn_export' => 'تصدير إلى إكسل',
        // Form & Table
        'reg_header' => 'تسجيل عميل جديد',
        'lbl_name' => 'الاسم الكامل',
        'lbl_phone' => 'رقم الجوال',
        'lbl_cat' => 'الفئة',
        'btn_save' => 'حفظ في قاعدة البيانات',
        'opt_gen' => 'عام',
        'opt_off' => 'عروض',
        'opt_vln' => 'متطوع',
        'opt_dawah' => 'دعوة',
        'back' => 'العودة للرئيسية',
        'date' => 'تاريخ التسجيل'
    ]
];

$text = $translations[$lang];
?>