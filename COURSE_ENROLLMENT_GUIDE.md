# Course Enrollment During Registration

## 🎯 Goal
Allow users to select their course during account creation, so they're automatically enrolled without admin intervention.

## ✅ Method 1: Self-Enrollment (Recommended)

This is the easiest and most flexible approach.

### Step 1: Enable Self-Enrollment Plugin

1. Go to: **Site Administration → Plugins → Enrolments → Manage enrol plugins**
2. Find: **"Self enrolment"**
3. Click the **eye icon** to enable it (if disabled)

### Step 2: Configure Courses for Self-Enrollment

For each course you want users to join:

1. Go to the course
2. Click: **"Participants"** (in course navigation)
3. Click: **Gear icon ⚙️** → **"Enrolment methods"**
4. Click: **"Add method"**
5. Select: **"Self enrolment"**
6. Configure settings:
   - **Custom instance name**: "Join this course" (or similar)
   - **Allow self enrolments**: Yes
   - **Enrolment key**: Leave blank (for open enrollment) or set a key
   - **Default role**: Student
   - **Enrolment duration**: Unlimited (or set duration)
7. Click: **"Add method"**

### Step 3: Users Can Now Self-Enroll

**For Users:**
1. Log in to Moodle
2. Go to: **Site home** or **Course catalog**
3. Browse available courses
4. Click: **"Enrol me"** button on desired course
5. If enrollment key required, enter it
6. Instantly enrolled!

### Benefits:
- ✅ No coding required
- ✅ Users choose their own courses
- ✅ No admin intervention needed
- ✅ Users can enroll in multiple courses
- ✅ Can use enrollment keys for restricted courses

---

## 🔧 Method 2: Course Selection During Signup (Advanced)

If you want course selection on the registration form itself:

### Option A: Use Cohorts + Auto-Enrollment

1. **Create Cohorts** (groups of users)
   - Site Administration → Users → Cohorts
   - Create cohort for each course (e.g., "Web Development Students")

2. **Add Custom Profile Field**
   - Site Administration → Users → User profile fields
   - Add custom field: "Select Your Course" (dropdown)
   - Options: List all courses

3. **Use Cohort Sync**
   - In each course: Participants → Enrolment methods
   - Add "Cohort sync" method
   - Link cohort to course

4. **Manual Step**: Admin assigns users to cohorts based on profile field

### Option B: Custom Plugin (Requires Development)

Create a custom enrollment plugin that:
1. Adds course dropdown to signup form
2. Automatically enrolls user on registration
3. Requires PHP development

**Basic Implementation:**

```php
// In auth plugin or custom local plugin
// Add to signup form
$mform->addElement('select', 'course_selection', 
    get_string('selectcourse', 'local_yourplugin'), 
    $course_options);

// On user creation
function user_signup($user) {
    global $DB;
    
    // Get selected course
    $courseid = $user->course_selection;
    
    if ($courseid) {
        // Enroll user in course
        $context = context_course::instance($courseid);
        $roleid = $DB->get_field('role', 'id', ['shortname' => 'student']);
        
        role_assign($roleid, $user->id, $context->id);
    }
}
```

---

## 🎨 Method 3: Course Catalog with Self-Service

Make it easy for users to find and join courses:

### Step 1: Enable Course Catalog

1. **Site Administration → Courses → Course default settings**
2. Set: **"Courses per page"** = 20 (or desired number)
3. Set: **"Course summary files limit"** = 1 (for course images)

### Step 2: Create Course Categories

1. **Site Administration → Courses → Manage courses and categories**
2. Create categories:
   - Web Development
   - Data Science
   - Design
   - etc.

### Step 3: Organize Courses

1. Move courses into appropriate categories
2. Add course images and descriptions
3. Enable self-enrollment for each

### Step 4: Customize Homepage

1. **Site Administration → Appearance → Front page settings**
2. Set: **"Front page"** = "List of categories" or "Course search box"
3. Users can browse and enroll

---

## 📋 Recommended Workflow

**For New Users:**

1. **User registers** (standard signup form)
2. **User logs in** for first time
3. **User sees course catalog** on homepage
4. **User clicks "Enrol me"** on desired course
5. **User is instantly enrolled** (if self-enrollment enabled)
6. **User starts learning!**

**For Admins:**

1. **Create courses**
2. **Enable self-enrollment** on each course
3. **Organize into categories**
4. **Set enrollment keys** (optional, for restricted courses)
5. **Monitor enrollments** via reports

---

## 🔐 Security Options

### Open Enrollment
- No enrollment key required
- Anyone can join
- Good for: Public courses, MOOCs

### Enrollment Key
- Users need a key to enroll
- Share key with authorized users
- Good for: Restricted courses, paid courses

### Approval Required
- Use "Manual enrolment" instead
- Admin approves each enrollment
- Good for: Limited capacity courses

---

## 📊 Monitoring Enrollments

**View Enrollments:**
1. Go to course
2. Click: **"Participants"**
3. See all enrolled users

**Enrollment Reports:**
1. **Site Administration → Reports → Course participation**
2. Filter by course and date range
3. Export to Excel if needed

---

## 🎯 Best Practice Recommendation

**Use Self-Enrollment with Course Catalog:**

1. ✅ Enable self-enrollment on all courses
2. ✅ Organize courses into clear categories
3. ✅ Add good course descriptions and images
4. ✅ Set enrollment keys only for restricted courses
5. ✅ Display course catalog on homepage
6. ✅ Add "Browse courses" link to navigation

**Benefits:**
- Users have freedom to choose
- No admin bottleneck
- Users can enroll in multiple courses
- Easy to manage
- Scalable

---

## 🚀 Quick Setup Commands

If you have CLI access, you can enable self-enrollment for all courses:

```bash
# Enable self-enrollment plugin
php admin/cli/cfg.php --name=enrol_plugins_enabled --set=manual,self

# For each course, add self-enrollment (requires custom script)
# Or do it manually via web interface
```

---

## 📞 Need Help?

- **Moodle Docs**: https://docs.moodle.org/en/Self_enrolment
- **Enrolment Plugins**: Site Administration → Plugins → Enrolments
- **Course Settings**: Each course → Settings → Users → Enrolment methods

---

**Recommendation: Start with Method 1 (Self-Enrollment). It's the easiest and most flexible!**
