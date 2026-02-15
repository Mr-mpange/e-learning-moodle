# Test Course Selection Plugin

## Quick Test Steps

### Step 1: Install Plugin
```
1. Go to: Site Administration → Notifications
2. You should see: "New version of plugin 'Course Selection on Signup' detected"
3. Click: "Upgrade Moodle database now"
4. Wait for completion
```

### Step 2: Verify Plugin is Installed
```
1. Go to: Site Administration → Plugins → Plugins overview
2. Search for: "courseselect"
3. You should see: "Course Selection on Signup" listed
```

### Step 3: Enable Self-Registration
```
1. Go to: Site Administration → Plugins → Authentication → Manage authentication
2. Find: "Email-based self-registration"
3. Click the eye icon to enable it (if disabled)
4. Click the settings icon
5. Ensure these are set:
   - "Allow new users to register" = Yes
   - Save changes
```

### Step 4: Create Test Course (if needed)
```
1. Go to: Site Administration → Courses → Manage courses and categories
2. Click: "Create new course"
3. Fill in:
   - Course full name: "Test Course"
   - Course short name: "TEST101"
4. Save
```

### Step 5: Test the Signup Form
```
1. Log out (or open incognito window)
2. Go to: /login/index.php
3. Click: "Create new account" link
4. You should see the form with these fields:
   - Username
   - Password
   - Email
   - Email (again)
   - First name
   - Last name
   - City/town
   - Country
   👉 **Select your course** ← THIS SHOULD BE HERE!
   
5. If you see the dropdown, SUCCESS! ✅
6. If not, continue to troubleshooting below
```

## Troubleshooting

### Issue: Dropdown doesn't appear

**Check 1: Plugin Installed?**
```
Site Administration → Plugins → Plugins overview
Search: "courseselect"
Should show: "Course Selection on Signup"
```

**Check 2: Self-Registration Enabled?**
```
Site Administration → Plugins → Authentication → Manage authentication
"Email-based self-registration" should have eye icon open (enabled)
```

**Check 3: Courses Exist?**
```
Site Administration → Courses → Manage courses and categories
Should have at least one visible course
```

**Check 4: Clear Caches**
```
Site Administration → Development → Purge caches
Click "Purge all caches"
```

**Check 5: Check Error Logs**
```
Site Administration → Reports → Logs
Look for errors related to "courseselect"
```

**Check 6: Verify Function Exists**
Add this to public/local/courseselect/lib.php at the top after defined():
```php
// Debug: Check if function is called
error_log('Course select plugin loaded');
```

Then check PHP error logs after visiting signup page.

### Issue: Dropdown appears but enrollment doesn't work

**Check 1: Event Observer Registered?**
```
Site Administration → Reports → Event list
Search for: "user_created"
Should show observer: "\local_courseselect\observer::user_created"
```

**Check 2: Manual Enrollment Enabled?**
```
Go to a course → Participants → Enrolment methods
Should have "Manual enrolments" enabled
```

**Check 3: Check Logs After Signup**
```
Site Administration → Reports → Logs
Filter by: User created events
Check if enrollment happened
```

## Manual Test

If automatic doesn't work, test manually:

```php
// Add to public/local/courseselect/test.php
<?php
require_once('../../config.php');
require_login();

$courses = $DB->get_records_select('course', 'id > 1 AND visible = 1', null, 'fullname', 'id, fullname');
echo '<pre>';
print_r($courses);
echo '</pre>';

// Test if function exists
if (function_exists('local_courseselect_extend_signup_form')) {
    echo "✅ Function exists!";
} else {
    echo "❌ Function NOT found!";
}
```

Visit: /local/courseselect/test.php

## Expected Behavior

**When Working Correctly:**
1. User visits signup page
2. Sees "Select your course" dropdown
3. Dropdown shows all visible courses
4. User selects course and completes registration
5. User is automatically enrolled in selected course
6. User can immediately access the course

## Debug Mode

Enable debugging to see errors:

```
Site Administration → Development → Debugging
Set "Debug messages" to "DEVELOPER"
Set "Display debug messages" to "Yes"
Save changes

Visit signup page and check for error messages
```

## Success Indicators

✅ Plugin appears in Plugins overview
✅ Dropdown appears on signup form
✅ Dropdown shows courses
✅ Form validates (requires course selection)
✅ User gets enrolled after signup
✅ User can access course immediately

## Still Not Working?

Try this alternative approach:

1. **Use Profile Field Instead:**
   - Site Administration → Users → User profile fields
   - Add custom field: "Course Selection" (dropdown)
   - Add course names as options
   - Admin manually enrolls based on profile field

2. **Use Self-Enrollment:**
   - Enable self-enrollment in each course
   - Users browse and enroll themselves
   - See: COURSE_ENROLLMENT_GUIDE.md

---

**Need more help? Check the Moodle error logs and PHP error logs for specific error messages.**
