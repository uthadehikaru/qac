# Inactive Member Reminder System

## Overview

The Inactive Member Reminder system automatically sends email notifications to members who have active orders but haven't completed any lessons for a specified number of days.

## Features

- **Smart Inactivity Detection**: 
  - For members with completed lessons: Checks days since last lesson
  - For members with no completed lessons: Checks days since order start date
- **Accurate Inactive Days**: Calculates and displays actual inactive days for each member
- **Configurable Inactive Days**: Set the number of inactive days via system configuration
- **Custom Email Template**: Beautiful email design matching the QAC brand
- **Scheduled Execution**: Runs automatically every day at 9:00 AM
- **Manual Execution**: Can be run manually via command line

## Configuration

### Setting Inactive Days

The number of inactive days is configured in the system settings:

```php
// In the database, set the system key
System::create([
    'key' => 'inactive_days',
    'value' => '3', // Number of days
    'is_array' => false
]);
```

### Email Template

The email template is located at `resources/views/emails/inactive-member-reminder.blade.php` and includes:

- QAC branding and logo
- Personalized greeting with member's name
- Reminder message with inactive days count
- "Belajar Sekarang" (Learn Now) button
- Mobile-responsive design

## Usage

### Manual Execution

Run the command manually to check for inactive members:

```bash
php artisan app:inactive-member
```

### Scheduled Execution

The command is automatically scheduled to run daily at 9:00 AM in `app/Console/Kernel.php`:

```php
$schedule->command('app:inactive-member')
         ->dailyAt('09:00')
         ->withoutOverlapping()
         ->runInBackground();
```

## How It Works

1. **Finds Active Members**: Queries members who have verified and active orders
2. **Checks Lesson Activity**: For each member, checks their last completed lesson
3. **Determines Inactivity**: 
   - If member has completed lessons: Checks if last lesson was within configured days
   - If member has never completed lessons: Checks from order start date
4. **Calculates Actual Inactive Days**: Uses the actual number of days since last activity
5. **Sends Notifications**: Sends personalized email reminders with accurate inactive days count

## Files Created/Modified

### New Files
- `app/Notifications/InactiveMemberReminder.php` - Email notification class
- `resources/views/emails/inactive-member-reminder.blade.php` - Email template
- `tests/Feature/InactiveMemberCommandTest.php` - Test cases
- `docs/inactive-member-reminder.md` - This documentation

### Modified Files
- `app/Console/Commands/InactiveMember.php` - Updated command logic
- `app/Models/Member.php` - Added relationships for orders and completed lessons
- `app/Console/Kernel.php` - Added scheduled task

## Testing

Run the test suite to verify functionality:

```bash
php artisan test tests/Feature/InactiveMemberCommandTest.php
```

## Email Preview

The email includes:
- Reminder banner with inactive days count
- QAC logo and branding
- Personalized greeting: "Assalaamu'alaikum"
- Custom message encouraging continued learning
- "Belajar Sekarang" button linking to member dashboard
- Professional footer with QAC Jakarta signature

## Troubleshooting

### Common Issues

1. **No emails sent**: Check if members have valid email addresses
2. **Wrong inactive days**: Verify system configuration for 'inactive_days'
3. **Command fails**: Ensure database connections and model relationships are correct

### Logs

Check Laravel logs for any errors:
```bash
tail -f storage/logs/laravel.log
```

## Future Enhancements

- Add email frequency controls (daily, weekly, etc.)
- Include progress tracking in emails
- Add unsubscribe functionality
- Implement different reminder levels (gentle, urgent, etc.)
