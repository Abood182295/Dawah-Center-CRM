<?php include('lang.php'); ?>
<!DOCTYPE html>
<html lang="<?php echo $lang; ?>" dir="<?php echo ($lang == 'ar' ? 'rtl' : 'ltr'); ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $text['title']; ?></title>
    <style>
    /* Global Reset & Fluid Typography */
    * {
        box-sizing: border-box;
        margin: 0;
        padding: 0;
    }

    html {
        font-size: clamp(16px, 2vw, 18px);
    }

    body { 
        font-family: system-ui, -apple-system, 'Segoe UI', sans-serif; 
        
        /* THE PREMIUM BACKGROUND */
        background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23007bff' fill-opacity='0.04'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        
        display: flex; 
        justify-content: center; 
        align-items: center; /* Centers the card vertically */
        min-height: 100vh;
        padding: 20px; /* Safe padding for tiny mobile screens */
    }

    /* Responsive Card Layout */
    .card { 
        background: white; 
        padding: clamp(20px, 5vw, 40px); /* Fluid padding */
        border-radius: 12px; 
        box-shadow: 0 8px 16px rgba(0.87,0.0,0.0,0.87); 
        width: 100%; 
        max-width: 450px; 
    }

    /* Back Link Styling */
    .back-link { 
        display: inline-block; 
        margin-bottom: 20px; 
        text-decoration: none; 
        color: #007bff; 
        font-weight: 500;
        transition: opacity 0.2s;
    }
    
    .back-link:hover { 
        opacity: 0.8; 
    }

    h2 {
        margin-bottom: 25px;
        color: #2c3e50;
        font-size: clamp(24px, 4vw, 32px);
        font-family: 'MG garamount',serif;
        text-align: center;
    }

    /* Touch-Friendly Form Elements */
    label {
        display: block;
        margin-bottom: 8px;
        font-weight: 600;
        color: #444;
    }

    input, select, button { 
        width: 100%; 
        padding: 14px; /* Larger touch target for tablets/phones */
        margin-bottom: 20px; 
        border: 1.5px solid #ddd; 
        border-radius: 8px; 
        font-size: 1rem; 
        font-family: inherit;
        transition: all 0.3s ease;
    }

    /* Accessibility Focus State */
    input:focus, select:focus {
        outline: none;
        border-color: #007bff;
        box-shadow: 0 0 0 3px rgba(0, 123, 255, 0.15);
    }

    button { 
        background: #28a745; 
        color: white; 
        border: none; 
        font-weight: bold; 
        cursor: pointer; 
        margin-bottom: 0;
        font-size: 1.1rem;
    }
    
    button:hover { 
        background: #218838; 
    }
</style>
</head>
<body>
    <div class="card">
        <a href="index.php" class="back-link">
            <?php echo ($lang == 'ar' ? '→ العودة للرئيسية' : '← Back to Dashboard'); ?>
        </a>
        <?php if (isset($_GET['status']) && $_GET['status'] == 'success'): ?>
           <div id="success-alert" style="background: #d4edda; color: #155724; padding: 15px; border-radius: 8px; margin-bottom: 20px; font-weight: bold; transition: opacity 0.5s ease;">
              <?php echo ($lang == 'ar' ? '✅ تم حفظ البيانات بنجاح!' : '✅ Data saved successfully!'); ?>
           </div>
        <?php endif; ?>
        <h2><?php echo $text['reg_header']; ?>
    
      </h2>
       <form id="registrationForm" action="save_beneficiary.php" method="POST">
    
    <div class="input-group" style="margin-bottom: 20px;">
        <label style="display: block; margin-bottom: 8px; font-weight: 600; color: #333;">
            <?php echo $text['lbl_name']; ?>
        </label>
        <input type="text" name="full_name" id="fullName" required 
               placeholder="<?php echo ($lang == 'ar' ? 'أدخل الاسم الكامل' : 'Enter full name'); ?>"
               style="width: 100%; padding: 12px; border: 1.5px solid #ddd; border-radius: 8px; font-size: 1rem; background: lightgray">
    </div>

    <div class="input-group" style="margin-bottom: 20px;">
        <label style="display: block; margin-bottom: 8px; font-weight: 600; color: #333;">
            <?php echo $text['lbl_phone']; ?>
        </label>
        <input type="tel" name="phone_number" id="phoneNumber" 
           required pattern="\+?[0-9]{7,15}" maxlength="16"
           placeholder="xxxxxxxxxx"
           oninput="validateForm()"
           style="width: 100%; padding: 12px; border: 1.5px solid #ddd; border-radius: 8px; background: lightgray">
        
      <small id="phoneError" style="color: #dc3545; display: none; margin-top: 5px;">
        <?php echo ($lang == 'ar' ? 'الرجاء إدخال رقم هاتف صحيح (7-15 رقم)' : 'Please enter a valid phone number (7-15 digits)'); ?>
    </small>
</div>

    <div class="input-group" style="margin-bottom: 25px;">
        <label style="display: block; margin-bottom: 8px; font-weight: 600; color: #333;">
            <?php echo $text['lbl_cat']; ?>
        </label>
        <select name="category" style="width: 100%; padding: 12px; border: 1.5px solid #0f0505; border-radius: 8px; font-size: 1rem; background: lightgray;">
            <option value="General"><?php echo $text['opt_gen']; ?></option>
            <option value="Lectures"><?php echo $text['opt_lectures']; ?></option>
            <option value="Projects"><?php echo $text['opt_projects']; ?></option>
            <option value="Library"><?php echo $text['opt_library']; ?></option>

        </select>
    </div>

    <button type="submit" name="submit" id="saveBtn" 
            style="background: #28a745; color: white; border: none; padding: 15px; width: 100%; border-radius: 8px; cursor: not-allowed; font-weight: bold; font-size: 1.1rem; opacity: 0.6;" 
            disabled>
        <?php echo ($lang == 'ar' ? 'حفظ في قاعدة البيانات' : 'Save to Database'); ?>
    </button>
</form>
    </div>


<script>
   document.addEventListener('DOMContentLoaded', () => {
    
    // --- 1. SUCCESS ALERT LOGIC ---
    const alertBox = document.getElementById('success-alert');
    if (alertBox) {
        setTimeout(() => {
            alertBox.style.transition = 'opacity 0.5s ease';
            alertBox.style.opacity = '0';
            setTimeout(() => { alertBox.remove(); }, 500);
        }, 3000);
    }

    // --- 2. URL CLEANUP ---
    if (window.history.replaceState && window.location.search.includes('status=success')) {
        const cleanUrl = window.location.pathname; 
        window.history.replaceState(null, '', cleanUrl);
    }

    // --- 3. INTERNATIONAL VALIDATION LOGIC ---
    const nameInput = document.getElementById('fullName');
    const phoneInput = document.getElementById('phoneNumber');
    const phoneError = document.getElementById('phoneError');
    const saveBtn = document.getElementById('saveBtn');

    function validateForm() {
    const nameInput = document.getElementById('fullName');
    const phoneInput = document.getElementById('phoneNumber');
    const phoneError = document.getElementById('phoneError');
    const saveBtn = document.getElementById('saveBtn');

    // NEW GLOBAL REGEX: Allows optional '+' and 7 to 15 digits
    const globalPattern = /^\+?[0-9]{7,15}$/;
    
    const isNameValid = nameInput.value.trim().length >= 3;
    const isPhoneValid = globalPattern.test(phoneInput.value);

    // Show error only if they have started typing and it's invalid
    if (phoneInput.value.length > 0 && !isPhoneValid) {
        phoneError.style.display = 'block';
    } else {
        phoneError.style.display = 'none';
    }

    // Guard the Save button
    if (isNameValid && isPhoneValid) {
        saveBtn.disabled = false;
        saveBtn.style.opacity = '1';
        saveBtn.style.cursor = 'pointer';
    } else {
        saveBtn.disabled = true;
        saveBtn.style.opacity = '0.6';
        saveBtn.style.cursor = 'not-allowed';
    }
}

    // Attach listeners so validation runs whenever the user types
    nameInput.addEventListener('input', validateForm);
    phoneInput.addEventListener('input', validateForm);

    // Run once on load in case the browser auto-filled the fields
    validateForm();
});
</script>
</body>
</html>