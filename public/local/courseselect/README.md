# Course Selection on Signup Plugin

## Description
This plugin adds a course selection dropdown to the user registration form, allowing new users to select and be automatically enrolled in a course when they create their account.

## Features
- Adds "Select your course" dropdown to signup form
- Lists all visible courses
- Automatically enrolls user in selected course after registration
- Assigns student role automatically
- No admin intervention required

## Installation

1. The plugin is already installed at: `public/local/courseselect/`

2. **Install the plugin:**
   - Go to: Site Administration → Notifications
   - Click: "Upgrade Moodle database now"
   - The plugin will be installed

3. **Enable email-based self-registration:**
   - Go to: Site Administration → Plugins → Authentication → Manage authentication
   - Enable: "Email-based self-registration"
   - Click the settings icon next to it
   - Ensure "Allow new users to register" is enabled

4. **Test it:**
   - Log out
   - Go to login page
   - Click "Create new account"
   - You should see "Select your course" dropdown
   - Fill in the form and select a course
   - After registration, user will be enrolled in that course

## How It Works

1. User visits registration page
2. Sees dropdown with all available courses
3. Selects desired course
4. Completes registration
5. Plugin automatically:
   - Creates user account
   - Enrolls user in selected course
   - Assigns student role
   - User can immediately access the course

## Requirements

- Moodle 4.3 or later
- Email-based self-registration enabled
- At least one visible course created

## Configuration

No configuration needed! The plugin works automatically once installed.

## Troubleshooting

### Dropdown doesn't appear
- Check that email-based self-registration is enabled
- Purge all caches
- Check that you have visible courses created

### User not enrolled after signup
- Check Moodle error logs
- Ensure manual enrolment is enabled in courses
- Check that student role exists

### No courses in dropdown
- Create at least one course
- Ensure courses are visible (not hidden)
- Check course visibility settings

## Uninstallation

1. Go to: Site Administration → Plugins → Plugins overview
2. Find: "Course Selection on Signup"
3. Click: "Uninstall"
4. Confirm

## Support

For issues, check:
- Moodle error logs
- Plugin installation status
- Authentication settings

## License

GPL v3 or later
