#  Paginate Class

This class is a general pagination class. It's configuration can be set either by passing an assoc array into it's configure() method, or by setting them individually using the public setter methods. If you use both, last one called takes presidence.

When you call the get() function, this class will return a 5 element array, with the keys being 'first', 'prev', 'pages', 'next', and 'last'

## What can be configured
- First Link Text *The text of the link that points to the first page
- Last Link Text *The text of the link that points to the last page
- Previous Link Text *The text of the link that points to the previous page
- Next Link Text *The text of the link that points to the next page
- Replacement Text *This is the text you want replaced in the Pagination HREF with the page number (http://www.domain.tld/page/|page_num|/view - |page_num| would be the replacement text)
- Pagination HREF *This is the href of the a tag that surrounds the pagination links (needs to include the Replacement Text)
- Total items *The total number of items
- Items per page *How many items will you be displaying per page?
- Current page *What page is currently being displayed?
- Number of pages *How many pages do you want displayed in your pagination links? This includes current page (see below for more details)
- First Link Wrap Tags *The tags to wrap around the link that points to the first page
- Last Link Wrap Tags *The tags to wrap around the link that points to the last page
- Previous Link Wrap Tags *The tags to wrap around the link that points to the previous page
- Next Link Wrap Tags *The tags to wrap around the link that points to the next page
- Numeric Link Wrap Tags *The tags to wrap around the individual page number links
- Current Page Wrap Tags *The tags to wrap around the current page text
- Page Link Separator *The separator to put in between the page links (separate the page links with a space, bullet, dash, etc) (see below for more details)

## The variables and their default values
- first_link_text = '<<'
- last_link_text = '>>'
- previous_link_text = '<'
- next_link_text = '>'
- replacement_text = '|page|'
- pagination_href = '/page/|page|'
- total_items = 100
- items_per_page = 20
- current_page = 1
- number_of_pages = 5
- first_link_wrap_tags = array('open' => '', 'close' => '')
- last_link_wrap_tags = array('open' => '', 'close' => '')
- previous_link_wrap_tags = array('open' => '', 'close' => '')
- next_link_wrap_tags = array('open' => '', 'close' => '')
- numeric_link_wrap_tags = array('open' => '', 'close' => '')
- current_page_wrap_tags = array('open' => '', 'close' => '')
- page_link_separator = '&nbsp;' *non-breaking space

## How to use the configure method
To use the configure method, simply make an assoc array, where the keys are the variable name you want to set, and the values are what you wish to set them to.
Example:

$config = array(
	'first_link_text' => 'FIRST',
	'last_link_text' => 'LAST',
	'previous_link_text' => 'PREV',
	'next_link_text' => 'NEXT'
);

$paginate = new Paginate();
$paginate->configure($config);

## How to use the public setter methods
The public setter methods are simply the variable name preceded by 'set_'.
Example:

$paginate = new Paginate();
$paginate->set_first_link_text('FIRST');
$paginate->set_last_link_text('LAST');
$paginate->set_previous_link_text('PREV');
$paginate->set_next_link_text('NEXT');

For the variables that contain the array defaults (first_link_wrap_tags, last_link_wrap_tags, previous_link_wrap_tags, next_link_wrap_tags, numeric_link_wrap_tags, current_page_wrap_tags), the public setters take two parameters ($open, $close)
Example:

$paginate = new Paginate();
$paginate->set_first_link_link_wrap_tags('&lt;div style="color:red;"&gt;', '&lt;/div&gt;');

