<?php

if(!defined('ABSPATH')){
    exit;
}

$spro_tour_content = array();

////////////////////////////
// Assistant Tour
////////////////////////////

$spro_tour_content['assistant']['.spro-header-menu'] = array(
    "title" => "Assistant",  
    "intro" => "Assistant adds AI to your site building process and lets you create content with just a few clicks (look for the AI option while editing your posts/pages). <br /><br />Assistant also helps you with several aspects of building and maintaning your WordPress website.",  
    "position" => "bottom", 
);

$spro_tour_content['assistant']['#spro-tours'] = array(
    "title" => "Tours",  
    "intro" => "Tours highlights and explains important options in WordPress that you will need while managing your site. <br /><br />You can replay the tours when needed.",  
    "position" => "right", 
);

$spro_tour_content['assistant']['#spro-features'] = array(
    "title" => "Recommended Features",  
    "intro" => "A recommended list of plugins to improve performace and extend functionalties for your site.",
    "position" => "right", 
);

$spro_tour_content['assistant']['#spro-quick-links'] = array(
    "title" => "Quick Links",  
    "intro" => "Here you will find important links compiled in a single section which can sometimes be difficult to find in WordPress.",  
    "position" => "left", 
);

$spro_tour_content['assistant']['#spro-settings'] = array(
    "title" => "Settings",  
    "intro" => "We have simplified complex WordPress settings that you can now manage with just a click via the Assistant.",  
    "position" => "left", 
);

$spro_tour_content['assistant']['#spro-ai'] = array(
    "title" => "AI",  
    "intro" => "Experience hassle-free site building with inbuilt AI in Assistant.",
    "position" => "left", 
);

$spro_tour_content['assistant']['#toplevel_page_assistant'] = array(
    "title" => "Your Assistant",  
    "intro" => "Assistant resides here, when you are unable to find something or having a hard time understanding a feature in WordPress we should be able to help you. <br /><br />Visit this page anytime.",  
    "position" => "right", 
);

///////////////////////////////////
// WordPress Sidebar
///////////////////////////////////

$spro_tour_content['sidebar']['#toplevel_page_assistant'] = array(
    "title" => "Your Assistant",  
    "intro" => "Assistant resides here, when you are unable to find something or having a hard time understanding a feature in WordPress we should be able to help you. <br /><br />Visit this page anytime.",  
    "position" => "right", 
);

$spro_tour_content['sidebar']['#wp-admin-bar-view-site'] = array(
    "title" => "Preview Site",  
    "intro" => "You can use this link to preview your site as a visitor.",  
    "position" => "right",
    "hover" => "true",
    "hover_selector" => "#wp-admin-bar-site-name",
);

$spro_tour_content['sidebar']['#menu-dashboard'] = array(
    "title" => "Dashboard",  
    "intro" => "The Dashboard is your website's command center, providing a concise summary of its activity, such as site health, recent updates, comments, and statistics. <br /><br />Several plugins also display quick summary like orders, products, etc within the dashboard. <br /><br />You can also check for Updates from the sub-menu.",  
    "position" => "right", 
);

$spro_tour_content['sidebar']['#menu-posts'] = array(
    "title" => "Posts",  
    "intro" => "Manage your blog posts here. <br /><br />Posts are typically utilized for blog posts, news updates, or articles, organized in a chronological order.",
    "position" => "right", 
); 

$spro_tour_content['sidebar']['#menu-media'] = array(
    "title" => "Media Library",  
    "intro" => "Manage media files like images, audio, videos, etc. here. <br /><br />Media uploaded from anywhere on your site can be managed here.",  
    "position" => "right", 
);

$spro_tour_content['sidebar']['#menu-pages'] = array(
    "title" => "Pages",
    "intro" => "Pages are static content sections such as Home, About Us, Contact, Services, etc. <br /><br />Use this menu to add, edit, delete your pages.",
    "position" => "right", 
); 

$spro_tour_content['sidebar']['#menu-comments'] = array(
    "title" => "Comments",  
    "intro" => "Here you can moderate comments posted by visitors on your posts. <br /><br />You can one click disable comments  for your entire site from the Assistant dashboard.",
    "position" => "right", 
); 

$spro_tour_content['sidebar']['#menu-appearance'] = array(
    "title" => "Appearance",
    "intro" => "Personalize your site's appearance effortlessly. <br /><br />Explore themes, customize headers, background, colors, manage widgets and menus to customize your site's look and feel.",  
    "position" => "right", 
); 

$spro_tour_content['sidebar']['#menu-plugins'] = array(
    "title" => "Plugins",
    "intro" => "Unlock endless possibilities for your website with plugins. <br /><br />Easily search, add or delete plugins to enhance your site's functionality.",  
    "position" => "right", 
); 

$spro_tour_content['sidebar']['#menu-users'] = array(
    "title" => "Users",
    "intro" => "Add or manage users to ensure smooth operation and collaboration.",  
    "position" => "right", 
);

$spro_tour_content['sidebar']['#menu-tools'] = array(
    "title" => "Tools",
    "intro" => "Import/Export site data, check site health or edit plugin/theme files from the Tools menu.",  
    "position" => "right", 
);

$spro_tour_content['sidebar']['#menu-settings'] = array(
    "title" => "Settings",
    "intro" => "Advanced settings for your site can be managed here. <br /><br />These settings include site title, tagline, site url, writing, reading, discussion, media, permalinks and more.<br /><br />Some plugins also add their settings page in this menu.",
    "position" => "right", 
);

$spro_tour_content['sidebar']['#collapse-menu'] = array(
    "title" => "Toggle Menu",
    "intro" => "Expand or Collapse the sidebar menu using this option.",
    "position" => "right", 
);

$spro_tour_content['sidebar']['#wp-admin-bar-user-info'] = array(
    "title" => "Edit Profile",  
    "intro" => "Here you can edit your profile information like name, email, password, bio, profile picture and more.",  
    "position" => "left",
    "hover" => "true",
    "hover_selector" => "#wp-admin-bar-my-account",
);

$spro_tour_content['sidebar']['#wp-admin-bar-logout'] = array(
    "title" => "Log Out",  
    "intro" => "Use this link to securely log out from your site.",
    "position" => "left",
    "hover" => "true",
    "hover_selector" => "#wp-admin-bar-my-account",
);

////////////////////////////
// Plugins Page
////////////////////////////

$spro_tour_content['plugins']['#menu-plugins'] = array(
    "title" => "Plugins",  
    "intro" => "Click here to add or manage plugins on your site.",  
    "position" => "right", 
);

$spro_tour_content['plugins']['.page-title-action'] = array(
    "title" => "Add New Plugin",  
    "intro" => "Here you can search wordpress.org plugins library or upload a custom plugin file to install a new plugin on your site.",
    "position" => "bottom",
);

$spro_tour_content['plugins']['tr[data-plugin]'] = array(
    "title" => "Installed Plugins List",  
    "intro" => "All your installed plugins active as well as inactive will be listed here.",  
    "position" => "bottom", 
);

$spro_tour_content['plugins']['td.plugin-title'] = array(
    "title" => "Plugin Actions",  
    "intro" => "You can perform actions for your plugins like Activate, Deactivate, Update, Delete, Plugin Settings and more.. <br /><br />It is recommended to delete plugins that you do not plan to use and keep all your plugins up to date.",  
    "position" => "bottom",
);

$spro_tour_content['plugins']['#bulk-action-selector-top'] = array(
    "title" => "Bulk Actions",  
    "intro" => "Choose bulk action for selected plugins: Activate, Deactivate, Update, Delete, toggle auto updates and more", 
    "position" => "bottom", 
);

$spro_tour_content['plugins']['.subsubsub'] = array(
    "title" => "Filter Installed Plugins",  
    "intro" => "Filter your installed plugins list with Active, Inactive, Auto Updates Enabled or Disabled options",
    "position" => "bottom",
);

$spro_tour_content['plugins']['#plugin-search-input'] = array(
    "title" => "Search Installed Plugins",  
    "intro" => "Search a plugin from the installed plugins list.",
    "position" => "bottom",
);

////////////////////////////
// Themes Page
//////////////////////////// 

$spro_tour_content['themes']['#menu-appearance'] = array(
    "title" => "Themes",
    "intro" => "Click here to add or manage themes on your site.",  
    "position" => "right", 
);

$spro_tour_content['themes']['.page-title-action'] = array(
    "title" => "Add New Theme",  
    "intro" => "Here you can search wordpress.org themes library or upload a custom theme file to install a new theme on your site.",
    "position" => "bottom", 
);

$spro_tour_content['themes']['.theme-browser'] = array(
    "title" => "Installed Themes List",  
    "intro" => "All your installed themes active as well as inactive will be listed here.",  
    "position" => "right", 
);

$spro_tour_content['themes']['.theme.active[data-slug]'] = array(
    "title" => "Active Theme",  
    "intro" => "Your active theme will be listed here.",  
    "position" => "right", 
);

$spro_tour_content['themes']['.theme-actions'] = array(
    "title" => "Theme Actions",  
    "intro" => "You can perform actions for your theme like Activate, Live Preview, Customize and more <br /><br />It is recommended to delete themes that you do not plan to use and keep all your themes up to date.",  
    "position" => "bottom",
);

$spro_tour_content['themes']['.search-box'] = array(
    "title" => "Search Installed Themes",  
    "intro" => "Search a theme from the installed themes list.",
    "position" => "bottom",
);

////////////////////////////
// WordPress Dashboard Page
////////////////////////////

$spro_tour_content['dashboard']['#menu-dashboard'] = array(
    "title" => "Dashboard",  
    "intro" => "The Dashboard is your website's command center, providing a concise summary of its activity, such as site health, recent updates, comments, and statistics. <br /><br />Several plugins also display quick summary like orders, products, etc within the dashboard.",  
    "position" => "right", 
);

$spro_tour_content['dashboard']['#dashboard_site_health'] = array(
    "title" => "Site Health",  
    "intro" => "Here you can get insights on the overall performance and security of your website. <br /><br />It offers recommendations and troubleshooting tools to help you maintain an efficient and secure site.",  
    "position" => "right", 
);

$spro_tour_content['dashboard']['#dashboard_right_now'] = array(
    "title" => "Info at a Glance",  
    "intro" => "Here you will get the number of posts, pages, comments, current version of WordPress and theme that you are running.",
    "position" => "right", 
);

$spro_tour_content['dashboard']['#dashboard_activity'] = array(
    "title" => "Activity",  
    "intro" => "Here you will get a quick summary of recent activity like published posts and comments received on your site.",  
    "position" => "right", 
);


$spro_tour_content['dashboard']['#dashboard_quick_press'] = array(
    "title" => "Quick Draft",  
    "intro" => "Use this section for capturing ideas as they come to you, quickly jot down the ideas for new posts. <br /><br />You can later access these drafts from the Posts section and continue editing them in the full post editor.",
    "position" => "left", 
);


$spro_tour_content['dashboard']['#dashboard_primary'] = array(
    "title" => "Events and News",  
    "intro" => "This widget is a valuable resource for staying informed about the latest happenings in the WordPress community and connecting with other WordPress enthusiasts. <br /><br />Here you will find updates on new releases, upcoming features, security updates, and general news about the WordPress community. <br /><br />This section also shows upcoming WordPress events such as WordCamps, local meetups, and other community gatherings.",  
    "position" => "left", 
);


$spro_tour_content['dashboard']['#screen-options-link-wrap'] = array(
    "title" => "Screen Options",  
    "intro" => "This useful feature allows you to select the screen elements that you would like to show or hide by using the checkboxes. <br /><br />You will find this option on several pages across your site.",
    "position" => "bottom", 
);

////////////////////////////
// Users Page
////////////////////////////

$spro_tour_content['users']['#menu-users'] = array(
    "title" => "Users",  
    "intro" => "Click here to add or manage users on your site.",  
    "position" => "right", 
);

$spro_tour_content['users']['.page-title-action'] = array(
    "title" => "Add New User",  
    "intro" => "Add a new user for your site. You can enter user details, password, role, etc.",
    "position" => "bottom",
);

$spro_tour_content['users']['tbody > tr'] = array(
    "title" => "Users List",  
    "intro" => "All your users with admin role as well as other roles will be listed here.",  
    "position" => "bottom", 
);

$spro_tour_content['users']['tbody > tr > td'] = array(
	"title" => "Edit User",
	"intro" => "You can edit the user information, change password, change role and much more with the Edit link here.",
	"position" => "bottom",
	"hover" => "true",
	"hover_selector" => ".row-actions",
	"hover_class" => "visible",
);

$spro_tour_content['users']['#bulk-action-selector-top'] = array(
    "title" => "Bulk Actions",  
    "intro" => "Choose bulk action for selected users: Delete or send password reset link", 
    "position" => "bottom", 
);

$spro_tour_content['users']['#new_role'] = array(
    "title" => "Change Role",  
    "intro" => "Here you can bulk change role for the selected users",  
    "position" => "bottom", 
);

$spro_tour_content['users']['.subsubsub'] = array(
    "title" => "Filter Users",  
    "intro" => "Filter your users list with their roles",
    "position" => "bottom",
);

$spro_tour_content['users']['.search-box'] = array(
    "title" => "Search Users",  
    "intro" => "Search a user from the users list.",
    "position" => "bottom",
);

////////////////////////////
// Posts Page
////////////////////////////

$spro_tour_content['posts']['#menu-posts'] = array(
    "title" => "Posts",  
    "intro" => "Click here to add or manage blog posts on your site.",  
    "position" => "right", 
);

$spro_tour_content['posts']['.page-title-action'] = array(
    "title" => "Add New Post",  
    "intro" => "Start writing a new blog post for your site.",
    "position" => "bottom",
);

$spro_tour_content['posts']['tbody > tr'] = array(
    "title" => "Posts List",  
    "intro" => "All the posts owned by all the users on your site will be listed here.",  
    "position" => "bottom", 
);

$spro_tour_content['posts']['tbody > tr > td'] = array(
    "title" => "Manage Post",  
    "intro" => "You can view, edit or delete the posts with the links here.",
    "position" => "bottom",
    "hover" => "true",
    "hover_selector" => ".row-actions",
    "hover_class" => "visible"
);

$spro_tour_content['posts']['#bulk-action-selector-top'] = array(
    "title" => "Bulk Actions",  
    "intro" => "Choose bulk action for selected posts: Quick Edit or Move to Trash.", 
    "position" => "bottom", 
);

$spro_tour_content['posts']['#filter-by-date'] = array(
    "title" => "Filter Posts by Date",  
    "intro" => "Here you can filter the posts by date.",  
    "position" => "bottom", 
);

$spro_tour_content['posts']['#cat'] = array(
    "title" => "Filter Posts by Category",  
    "intro" => "Here you can filter the posts by category.",  
    "position" => "bottom", 
);

$spro_tour_content['posts']['.subsubsub'] = array(
    "title" => "Filter Posts",  
    "intro" => "Filter your posts list by their status like published, drafts, trash, etc.",
    "position" => "bottom",
);

$spro_tour_content['posts']['.search-box'] = array(
    "title" => "Search Posts",  
    "intro" => "Search a post from the posts list.",
    "position" => "bottom",
);

////////////////////////////
// Pages Page
////////////////////////////

$spro_tour_content['pages']['#menu-pages'] = array(
    "title" => "Pages",  
    "intro" => "Click here to add or manage pages on your site.",  
    "position" => "right", 
);

$spro_tour_content['pages']['.page-title-action'] = array(
    "title" => "Add New Page",  
    "intro" => "Start creating a new page for your site.",
    "position" => "bottom",
);

$spro_tour_content['pages']['tbody > tr'] = array(
    "title" => "Pages List",  
    "intro" => "All the pages on your site will be listed here.",
    "position" => "bottom", 
);

$spro_tour_content['pages']['tbody > tr > td'] = array(
    "title" => "Manage Page",  
    "intro" => "You can view, edit or delete the pages with the links here.",
    "position" => "bottom",
    "hover" => "true",
    "hover_selector" => ".row-actions",
    "hover_class" => "visible"
);

$spro_tour_content['pages']['#bulk-action-selector-top'] = array(
    "title" => "Bulk Actions",  
    "intro" => "Choose bulk action for selected pages: Quick Edit or Move to Trash.", 
    "position" => "bottom", 
);

$spro_tour_content['pages']['#filter-by-date'] = array(
    "title" => "Filter Pages by Date",  
    "intro" => "Here you can filter the pages by date.",  
    "position" => "bottom", 
);

$spro_tour_content['pages']['.subsubsub'] = array(
    "title" => "Filter Pages",  
    "intro" => "Filter your pages list by their status like published, drafts, trash, etc.",
    "position" => "bottom",
);

$spro_tour_content['pages']['.search-box'] = array(
    "title" => "Search Pages",  
    "intro" => "Search a page from the pages list.",
    "position" => "bottom",
);

