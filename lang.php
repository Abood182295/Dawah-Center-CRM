<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
    }
// Default to Arabic if no session is set
if (!isset($_SESSION['lang'])) {
    $_SESSION['lang'] = 'ar';
    }
// Handle language switching
if (isset($_GET['lang'])) {
    $_SESSION['lang'] = $_GET['lang'];
    header("Location: " . strtok($_SERVER['REQUEST_URI'], '?'));
    exit();
}

$lang = $_SESSION['lang'];

$translations = [
    'en' => [
        // Header & Dashboard
        'title'             => 'Beneficiary Management System',
        'welcome'           => 'Welcome to the Management Portal. Select an action below:',
        'switch'            => 'العربية',
        'back'              => 'Back to Dashboard',
        'back_to_db'        => 'Back to Beneficiary Database',
        
        // Main Actions
        'add_cust'          => 'Add Beneficiary',
        'add_desc'          => 'Register new book recipients',
        'view_db'           => 'Beneficiary Database',
        'view_desc'         => 'Search and manage lists',
        'send_msg'          => 'Send Messages',
        'send_desc'         => 'Send group messages',
        'coming_soon'       => '(Coming Soon...)',
        
        // Forms & Registration
        'reg_header'        => 'Beneficiary Registration',
        'lbl_name'          => 'Full Name',
        'lbl_phone'         => 'Phone Number',
        'lbl_cat'           => 'Category',
        'btn_save'          => 'Save to Database',
        'date'              => 'Registration Date',
        'phone_error' => 'Please enter a valid phone number (7-15 digits)',
        
        // Categories
        'opt_gen'      => 'General',
        'opt_lectures' => 'Lectures & Lessons',
        'opt_projects' => 'Programs & Projects',
        'opt_library'  => 'The Library',
        
        // Table & Actions
        'actions'           => 'Actions',
        'edit'              => 'Edit',
        'delete'            => 'Delete',
        'edit_title'        => 'Edit Beneficiary Information',
        'update_btn'        => 'Update Record',
        'confirm_delete'    => 'Are you sure you want to delete this beneficiary?',
        'success_update'    => 'Beneficiary updated successfully!',
        
        // Search & Import/Export
        'search_placeholder'=> 'Search by name or number...',
        'filter_btn'        => 'Search',
        'all_cats'          => 'All Categories',
        'btn_print'         => 'Print Report',
        'btn_export'        => 'Export to Excel',
        'import_title'      => 'Import Beneficiaries from CSV',
        'select_file'       => 'Select CSV File',
        'btn_upload'        => 'Upload and Import',
        'import_success'    => 'Records imported successfully!',
        'import_error'      => 'Error importing data. Check file format.',
        
        // Messaging
        'broadcast_header'  => 'Send Broadcast Message',
        'select_cat'        => 'Select Category to Message',
        'msg_placeholder'   => 'Type your message here...',
        'send_btn'          => 'Prepare Dispatch',
        'count_label'       => 'Total beneficiaries in this category: ',
        'preview_header'    => 'Mobile Preview',
    ],
    
    'ar' => [
        // Header & Dashboard
        'title'             => 'نظام إدارة المستفيدين',
        'welcome'           => 'مرحباً بك في بوابة الإدارة. الرجاء اختيار إجراء من القائمة:',
        'switch'            => 'English',
        'back'              => 'العودة للرئيسية',
        'back_to_db'        => 'العودة لقاعدة بيانات المستفيدين',
        // Main Actions
        'add_cust'          => 'إضافة مستفيد',
        'add_desc'          => 'تسجيل مستلمي الكتب الجدد',
        'view_db'           => 'قاعدة بيانات المستفيدين',
        'view_desc'         => 'البحث وإدارة القوائم',
        'send_msg'          => 'إرسال رسائل',
        'send_desc'         => 'إرسال رسائل جماعية',
        'coming_soon'       => '(قريباً...)',
        
        // Forms & Registration
        'reg_header'        => 'تسجيل مستفيد جديد',
        'lbl_name'          => 'الاسم الكامل',
        'lbl_phone'         => 'رقم الجوال',
        'lbl_cat'           => 'الفئة',
        'btn_save'          => 'حفظ في قاعدة البيانات',
        'date'              => 'تاريخ التسجيل',
        'phone_error' => 'الرجاء إدخال رقم هاتف صحيح (7-15 رقم)',
        // Categories
        'opt_gen'      => 'عام',
        'opt_lectures' => 'محاضرات و دروس علمية',
        'opt_projects' => 'برامج و مشاريع',
        'opt_library'  => 'المكتبة',
             
        // Table & Actions
        'actions'           => 'الإجراءات',
        'edit'              => 'تعديل',
        'delete'            => 'حذف',
        'edit_title'        => 'تعديل بيانات المستفيد',
        'update_btn'        => 'تحديث البيانات',
        'confirm_delete'    => 'هل أنت متأكد من حذف هذا المستفيد؟',
        'success_update'    => 'تم تحديث بيانات المستفيد بنجاح!',
        
        // Search & Import/Export
        'search_placeholder'=> 'ابحث بالاسم أو الرقم...',
        'filter_btn'        => 'بحث',
        'all_cats'          => 'كل الفئات',
        'btn_print'         => 'طباعة التقرير',
        'btn_export'        => 'تصدير إلى إكسل',
        'import_title'      => 'استيراد المستفيدين من ملف CSV',
        'select_file'       => 'اختر ملف CSV',
        'btn_upload'        => 'رفع واستيراد',
        'import_success'    => 'تم استيراد البيانات بنجاح!',
        'import_error'      => 'خطأ في استيراد البيانات. يرجى التحقق من صيغة الملف.',
        
        // Messaging
        'broadcast_header'  => 'إرسال رسالة جماعية',
        'select_cat'        => 'اختر الفئة المستهدفة',
        'msg_placeholder'   => 'اكتب نص الرسالة هنا...',
        'send_btn'          => 'تجهيز الإرسال',
        'count_label'       => 'إجمالي المستفيدين في هذه الفئة: ',
        'preview_header'    => 'معاينة الهاتف',
    ]
];

$text = $translations[$lang];
?>