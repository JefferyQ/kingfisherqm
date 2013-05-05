<?php

class Lang {

    public $lang;

    function __construct() {

	$this->lang['main'] = 'Main';
	$this->lang['tables'] = 'Tables'; 
	$this->lang['reports'] = 'Reports';
	$this->lang['graphics'] = 'Graphics';
	$this->lang['settings'] = 'Settings';
	$this->lang['help'] = 'Help';
	$this->lang['logout'] = 'Logout';
	$this->lang['logged_as'] = 'Logged as';	

	$this->lang['users'] = 'Users';
	$this->lang['sectors'] = 'Sectors';
	$this->lang['costscenter'] = 'Costs Center';
	$this->lang['printers'] = 'Printers';
	$this->lang['paperformats'] = 'Paper Formats';

	$this->lang['list_all_jobs'] = 'List All Jobs';
	$this->lang['search_jobs'] = 'Search Jobs';
	$this->lang['total_pages'] = 'Total Pages';
	$this->lang['total_pages_grouped'] = 'Total Pages Grouped';

	$this->lang['top_10_users'] = 'Top 10 Users';
	$this->lang['top_10_printers'] = 'Top 10 Printers';
	$this->lang['top_10_paperformats'] = 'Top 10 Paper Formats';
	$this->lang['colormode'] = 'Colormode';

	$this->lang['print_queue'] = 'Print Queue';
	$this->lang['last_jobs'] = 'Last Jobs';
	$this->lang['about'] = 'About';

	$this->lang['login'] = 'Login';
	$this->lang['password'] = 'Password';
	$this->lang['send'] = 'Send';

	$this->lang['add_new_sector'] = 'Add new sector';
	$this->lang['delete_this_sector'] = 'Delete this sector';
	$this->lang['new_sector_name'] = 'New sector name';

	$this->lang['add_new_costcenter'] = 'Add new cost center';
	$this->lang['delete_this_costcenter'] = 'Delete this cost center';
	$this->lang['new_costcenter_name'] = 'New cost center name';

	$this->lang['date'] = 'Date';
	$this->lang['time'] = 'Time';
	$this->lang['user'] = 'User';
	$this->lang['title'] = 'Title';
	$this->lang['printer'] = 'Printer';
	$this->lang['paperformat'] = 'Paper Format';
	$this->lang['status'] = 'Status';
	$this->lang['job_size'] = 'Job Size';
	$this->lang['copies'] = 'Copies';
	$this->lang['number_of_pages'] = 'N&#176; Pages';
	$this->lang['total_pages'] = 'Total Pages';

	$this->lang['user_settings'] = 'User Settings';
	$this->lang['sector'] = 'Sector';
	$this->lang['costcenter'] = 'Cost Center';
	$this->lang['jobs_in_default_sector'] = 'Jobs in default sector';
	$this->lang['jobs_in_default_costcenter'] = 'Jobs in default cost center';
	$this->lang['total_price'] = 'Total Price';
	$this->lang['alter_to_sector'] = 'Alter to sector';
	$this->lang['alter_to_costcenter'] = 'Alter to cost center';

	$this->lang['begin'] = 'Begin';
	$this->lang['end'] = 'End';
	$this->lang['year'] = 'Year';
	$this->lang['month'] = 'Month';
	$this->lang['day'] = 'Day';
	$this->lang['search'] = 'Search';

	$this->lang['page_price'] = 'Page Price';
	$this->lang['add_page_price'] = 'Add to Page Price';
	$this->lang['price_gray'] = 'Price Gray';
	$this->lang['price_color'] = 'Price Color';

	$this->lang['queue_paused'] = 'Queue Paused';

	$this->lang['language'] = 'Language';
    }

}

?>
