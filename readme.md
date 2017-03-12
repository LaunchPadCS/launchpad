## LaunchPad

LaunchPad is an open source Content Management System (CMS) built with Laravel, and is used to manage the LaunchPad community at Purdue. This application can be used and extended to build your own mentorship community! Currently, the following features are supported

- User groups and permissions (administrators, mentors, mentees)
- User management
- Dynamic form builder for user applications
- Applicant management (viewing applications, sorting, filtering)
- Simple interview platform
- Community profiles

## Setup
First, ensure that you have the following prerequisites installed:
- PHP >= 5.6.4
- MySQL
- [Composer](https://getcomposer.org/)
- OpenSSL PHP Extension
- PDO PHP Extension
- Mbstring PHP Extension
- Tokenizer PHP Extension
- XML PHP Extension

Download the source via `git clone` or the .zip option. Enter the directory through a command prompt, and run `composer install`.

Then, copy `.env.example` to `.env`, and fill in the all the `DB_` values.

Finally, run:
- `php artisan key:generate`
- `php artisan migrate`
- `php artisan db:seed`
- `php artisan storage:link`

Start your web server, and you should see LaunchPad running!

## License

LaunchPad is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT).
