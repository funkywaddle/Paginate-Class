<?php
class paginate
{

	/////////////////////////////////////////////////////////////////////////////////////
	///                              Private Variables                                ///
	/////////////////////////////////////////////////////////////////////////////////////

	/**
	 * Link Text for the First Link
	 */
	private $first_link_text;

	/**
	 * Link Text for the Last Link.
	 */
	private $last_link_text;

	/**
	 * Link Text for the Previous Link.
	 */
	private $previous_link_text;

	/**
	 * Link Text for the Next Page.
	 */
	private $next_link_text;
	
	/**
	 *   Text to search for in href to replace with pagination page number
	 *   If set to |page|
	 *   /categories/page/|page| will be outputted as /categories/page/1
	 *   /categories/page/|page|/somethingelse will be outputted as /categories/page/1/somethingelse
	 */
	private $replacement_text;

	/**
	 *   Path to link pagination links to
	 *   See $replacement_text for format
	 */
	private $pagination_href;

	/**
	 * Total number of items
	 */
	private $total_items;

	/**
	 * Number of items to show per page
	 */
	private $items_per_page;

	/**
	 * Current Page
	 * This is a 1 based number -> Page 1 = first page
	 */
	private $current_page;

	/**
	 *   Number of pages to show
	 *   If total number of pages exceeds this number, this will be the number of links shown
	 *   Else the number of pages shown will be the number of pages there are
	 *
	 *   Example:
	 *   If 20 pages, and $number_of_pages = 5
	 *         5 pages will show
	 *   Else If 3 pages, and $number_of_pages = 5
	 *         3 pages will show
	 *
	 *   If set to an even number, then more links will appear after, then before
	 *   Else, the links before and links after will be even
	 *   Unless there are not enough links before to show the needed amount, then another link will be after
	 *
	 *   Example:
	 *   If 20 pages, and $number_of_pages = 4, and you are on page 6
	 *         Pages 5, 6, 7, and 8 will appear, with 6 being the current page (1 before, 2 after)
	 *   If 20 pages, and $number_of_pages = 5, and you are on page 6
	 *         Pages 4, 5, 6, 7, and 8 will appear, with 6 being the current page (2 before, 2 after)
	 *   If 20 pages, and $number_of_pages = 5, and you are on page 2
	 *         Pages 1, 2, 3, 4, and 5 will appear with 2 being the current page (1 before, 3 after)
	 *
	 */
	private $number_of_pages;

	/**
	 *   An array of tags to wrap the $first_link with
	 *   Example:
	 *   $first_link_wrap_tags = array('open' => '<b>', 'close'=>'</b>') will become
	 *   <a href=""><b>$first_link</b></a>
	 */
	private $first_link_wrap_tags;

	/**
	 *   An array of tags to wrap the $last_link with
	 *   Example:
	 *   $last_link_wrap_tags = array('open' => '<b>', 'close'=>'</b>') will become
	 *   <a href=""><b>$last_link</b></a>
	 */
	private $last_link_wrap_tags;

	/**
	 *   An array of tags to wrap the $previous_link with
	 *   Example:
	 *   $previous_link_wrap_tags = array('open' => '<b>', 'close'=>'</b>') will become
	 *   <a href=""><b>$previous_link</b></a>
	 */
	private $previous_link_wrap_tags;

	/**
	 *   An array of tags to wrap the $next_link with
	 *   Example:
	 *   $next_link_wrap_tags = array('open' => '<b>', 'close'=>'</b>') will become
	 *   <a href=""><b>$next_link</b></a>
	 */
	private $next_link_wrap_tags;

	/**
	 *   An array of tags to wrap the numeric links with
	 *   Example:
	 *   $numeric_link_wrap_tags = array('open' => '<b>', 'close'=>'</b>') will become
	 *   <a href=""><b>1</b></a>
	 */
	private $numeric_link_wrap_tags;

	/**
	 *   An array of tags to wrap the current page numeral with
	 *   Example:
	 *   $current_page_wrap_tags = array('open' => '<b>', 'close'=>'</b>') will become
	 *   <b>1</b>
	 */
	private $current_page_wrap_tags;
	
	/**
	 *   The string that separates the page links
	 *   Example:
	 *   $page_link_separator = '&nbsp;|&nbsp;' will become
	 *   <a href="">1</a>&nbsp;|&nbsp;<a href="">2</a>
	 */
	private $page_link_separator;
	 


	public function __construct()
	{
		//Set defaults
		$this->first_link_text = '<<';
		$this->last_link_text = '>>';
		$this->previous_link_text = '<';
		$this->next_link_text = '>';
		$this->replacement_text = '|page|';
		$this->pagination_href = '/page/' . $this->replacement_text;
		$this->total_items = 100;
		$this->items_per_page = 20;
		$this->current_page = 1;
		$this->number_of_pages = 5;
		$this->first_link_wrap_tags = array('open' => '', 'close' => '');
		$this->last_link_wrap_tags = array('open' => '', 'close' => '');
		$this->previous_link_wrap_tags = array('open' => '', 'close' => '');
		$this->next_link_wrap_tags = array('open' => '', 'close' => '');
		$this->numeric_link_wrap_tags = array('open' => '', 'close' => '');
		$this->current_page_wrap_tags = array('open' => '', 'close' => '');
		$this->page_link_separator = '&nbsp;';
	}

	/////////////////////////////////////////////////////////////////////////////////////
	///                              Public Setter Methods                            ///
	/////////////////////////////////////////////////////////////////////////////////////

	/**
	 * This function is used to set the text of the 'First' link
	 * 
	 * @param String $first_link
	 * @return void
	 */
	public function set_first_link_text( $first_link )
	{
		if( ! empty( $first_link ) )
		{
			$this->first_link_text = htmlentities( $first_link );
		}
	}

	/**
	 * This function is used to set the text of the 'Last' link
	 * 
	 * @param String $last_link
	 * @return void
	 */
	public function set_last_link_text( $last_link )
	{
		if( ! empty ( $last_link ) )
		{
			$this->last_link_text = htmlentities( $last_link );
		}
	}

	/**
	 * This function is used to set the text of the 'Next' link
	 * 
	 * @param String $next_link
	 * @return void
	 */
	public function set_next_link_text( $next_link )
	{
		if( ! empty ( $next_link ) )
		{
			$this->next_link_text = htmlentities( $next_link );
		}
	}

	/**
	 * This function is used to set the text of the 'Previous' link
	 * 
	 * @param String $prev_link
	 * @return void
	 */
	public function set_previous_link_text( $prev_link )
	{
		if( ! empty ( $prev_link ) )
		{
			$this->previous_link_text = htmlentities( $prev_link );
		}
	}

	/**
	 * This function is used to set the replacement text in your pagination href
	 * If you set this to |page|, then when the pagination links are rendered,
	 * all occurances of |page| will be replaced by the current page number
	 * 
	 * This allows you to inject your page numbers into the middle of a URL
	 *
	 * Example:
	 * This is set to |page|
	 * href = '/categories/|page|/option/green'
	 * When you output the text in your view, it will be
	 * <a href="/categories/1/option/green">1</a> (for Page 1)
	 * <a href="/categories/2/option/green">2</a> (for Page 2)
	 * ...and so on
	 * 
	 * @param String $first_link
	 * @return void
	 */
	public function set_replacement_text( $repl_text )
	{
		if( ! empty ( $repl_text ) )
		{
			$this->replacement_text = $repl_text;
		}
	
	}

	/**
	 * This function is used to set the link target for each of the pagination links
	 * Remember to use the replacement text in the string you pass into this function
	 *
	 * Example:
	 * If replacement text is set to |page|, and you want your links to point to /categories/1
	 * then you need to pass in /categories/|page| to this function
	 * 
	 * @param String $href
	 * @return void
	 */
	public function set_pagination_href( $href )
	{
		if( ! empty ( $href ) )
		{
			$href = str_ireplace('&amp;', '&', $href); // so as not to turn &amp; into &amp;amp; when urlencoding and htmlentiting

			$this->pagination_href = htmlentities( urlencode( $href ) );
		}
	}

	/**
	 * This function is used to set the total number of items in the item set
	 * The number passed into this function will be used to calculate the total number of pages
	 *   this set contains (using this number and the number of items per page)
	 *
	 * @param int $total
	 * @return void
	 */
	public function set_total_items( $total )
	{
		if( ( is_numeric( $total ) ) && ( $total > 0 ) && ( is_int( $total ) ) )
		{
			$this->total_items = $total;
		}
	}

	/**
	 * This function is used to set the number of items you want displayed per page
	 * The number passed into this function will be used to calculate the total number of pages
	 *   this set contains (using this number and the number of total items
	 *
	 * @param int $per_page
	 * @return void
	 */
	public function set_items_per_page( $per_page )
	{
		if( ( is_numeric( $per_page ) ) && ( $per_page > 0 ) && ( is_int( $per_page ) ) )
		{
			$this->items_per_page = $per_page;
		}
	}

	/**
	 * This function is used to set the current page
	 *
	 * @param int $cur_page
	 * @return void
	 */
	public function set_current_page( $cur_page )
	{
		if( ( is_numeric( $cur_page ) ) && ( $cur_page > 0 ) && ( is_int( $cur_page ) ) )
		{
			$this->current_page = $cur_page;
		}
	}

	/**
	 *   Number of pages to show
	 *   If total number of pages exceeds this number, this will be the number of pages shown (including current page)
	 *   Else the number of pages shown will be the number of pages there are
	 *
	 *   Example:
	 *   If 20 pages, and $num_pages = 5
	 *         5 pages will show
	 *   Else If 3 pages, and $num_pages = 5
	 *         3 pages will show
	 *
	 *   If set to an even number, then more links will appear after the current page, then before
	 *   Else, the links before and links after will be even
	 *   Unless there are not enough links before to show the needed amount, then another link will be after
	 *
	 *   Example:
	 *   If 20 pages, and $num_pages = 4, and you are on page 6
	 *         Pages 5, 6, 7, and 8 will appear, with 6 being the current page (1 before, 2 after)
	 *   If 20 pages, and $num_pages = 5, and you are on page 6
	 *         Pages 4, 5, 6, 7, and 8 will appear, with 6 being the current page (2 before, 2 after)
	 *   If 20 pages, and $num_pages = 5, and you are on page 2
	 *         Pages 1, 2, 3, 4, and 5 will appear with 2 being the current page (1 before, 3 after)
	 *
	 * @param int $num_pages
	 * @return void
	 */
	public function set_number_of_pages( $num_pages )
	{
		if( ( is_numeric( $num_pages ) ) && ( $num_pages > 0 ) && ( is_int( $num_pages ) ) )
		{
			$this->number_of_pages = $num_pages;
		}
	}

	/**
	 * This function is used to set the parent tags of the First Link
	 * 
	 * Example:
	 *
	 * if you set this to ('<div class="first">','<div>')
	 * The output would be:
	 * <div class="first"><a href="">First Link</a></div>
	 *
	 * @param string $front
	 * @param string $back
	 * @return void
	 */
	public function set_first_link_wrap_tags( $front, $back )
	{
		$this->first_link_wrap_tags['open'] = $front;
		$this->first_link_wrap_tags['close'] = $back;
	}

	/**
	 * This function is used to set the parent tags of the Last Link
	 * 
	 * Example:
	 *
	 * if you set this to ('<div class="last">','<div>')
	 * The output would be:
	 * <div class="last"><a href="">Last Link</a></div>
	 *
	 * @param string $front
	 * @param string $back
	 * @return void
	 */
	public function set_last_link_wrap_tags( $front, $back )
	{
		$this->last_link_wrap_tags['open'] = $front;
		$this->last_link_wrap_tags['close'] = $back;
	}

	/**
	 * This function is used to set the parent tags of the Previous Link
	 * 
	 * Example:
	 *
	 * if you set this to ('<div class="prev">','<div>')
	 * The output would be:
	 * <div class="prev"><a href="">Previous Link</a></div>
	 *
	 * @param string $front
	 * @param string $back
	 * @return void
	 */
	public function set_previous_link_wrap_tags( $front, $back )
	{
		$this->previous_link_wrap_tags['open'] = $front;
		$this->previous_link_wrap_tags['close'] = $back;
	}

	/**
	 * This function is used to set the parent tags of the Next Link
	 * 
	 * Example:
	 *
	 * if you set this to ('<div class="next">','<div>')
	 * The output would be:
	 * <div class="next"><a href="">Next Link</a></div>
	 *
	 * @param string $front
	 * @param string $back
	 * @return void
	 */
	public function set_next_link_wrap_tags( $front, $back )
	{
		$this->next_link_wrap_tags['open'] = $front;
		$this->next_link_wrap_tags['close'] = $back;
	}

	/**
	 * This function is used to set the parent tags of the Numeric Links
	 * 
	 * Example:
	 *
	 * if you set this to ('<div class="num">','<div>')
	 * The output would be:
	 * <div class="num"><a href="">1</a></div>
	 *
	 * @param string $front
	 * @param string $back
	 * @return void
	 */
	public function set_numeric_link_wrap_tags( $front, $back )
	{
		$this->numeric_link_wrap_tags['open'] = $front;
		$this->numeric_link_wrap_tags['close'] = $back;
	}

	/**
	 * This function is used to set the parent tags of the Current Page
	 * 
	 * Example:
	 *
	 * if you set this to ('<div class="cur_page">','<div>')
	 * The output would be:
	 * <div class="cur_page">1</div>
	 *
	 * @param string $front
	 * @param string $back
	 * @return void
	 */
	public function set_current_page_wrap_tags( $front, $back )
	{
		$this->current_link_page_tags['open'] = $front;
		$this->current_link_page_tags['close'] = $back;
	}
	
	/**
	 * This function is used to set the page link separator.
	 * The page link separator is what is to be shown between each
	 * numeric page number. This will not be used between the
	 * First, Previous, Next, or Last links. Only the numeric links
	 * (and current page)
	 *
	 * Example:
	 *
	 * if you set this to '&nbsp;|&nbsp;'
	 * The output would be:
	 * <a href="">1</a>&nbsp;|&nbsp;<a href="">2</a>
	 *
	 * @param string $link_sep
	 * @return void
	 */
	public function set_page_link_separator( $link_sep )
	{
		$this->page_link_separator = $link_sep;
	}

	/**
	 * This function is used in lieu of the individual public setter functions - whichever is called last will be what items are set to
	 * This function takes an associative array with the keys being the variable names
	 *    and the values being what you want them set to
	 *
	 * Example:
	 * $paginate_array(
	 *     'first_link_text' => 'First',
	 *     'last_link_text'  => 'Last',
	 *     'replacement_text => '*replace*',
	 *     'first_link_wrap_tags' => array('<div class="first">','</div>')
	 * );
	 *
	 * Note:
	 * The *_wrap_tags elements require them to be arrays with element 0 being what you want the opening tag to be
	 *     and element 1 being what you want the closing tag to be.
	 *
	 * @param array $config_array
	 * @return void
	 */
	public function configure( $config_array )
	{
		if( is_array( $config_array ) )
		{
			foreach( $config_array as $attrib => $val )
			{
				if( method_exists( $this, 'set_' . $attrib ) )
				{
					if( is_array( $val ) )
					{
						$this->{'set_' . $attrib}($val[0], $val[1]);
					}
					else
					{
						$this->{'set_' . $attrib}($val);
					}
				}
			}
		}
	}

	/////////////////////////////////////////////////////////////////////////////////////
	///                                   Get Paginate                                ///
	/////////////////////////////////////////////////////////////////////////////////////

	/**
	 * This function returns the pagination values based on what was set or using default values
	 * 
	 * What is returned:
	 * array(
	 *     first => entire anchor tag for the first link
	 *     last  => entire anchor tag for the last link
	 *     prev  => entire anchor tag for the previous link
	 *     next  => entire anchor tag for the next link
	 *     pages => string containing multiple anchor tags for the individual pages, and the current page.
	 * );
	 *
	 * @param void
	 * @return array @paginate
	 */
	public function get()
	{
		//Whether or not to fill first, prev, next, and last links
		$first = true;
		$prev = true;
		$next = true;
		$last = true;

		//Create Paginate skeleton
		$paginate = array();
		$paginate['first'] = '';
		$paginate['prev'] = '';
		$paginate['pages'] = '';
		$paginate['next'] = '';
		$paginate['last'] = '';

		//Get total pages needed
		$total_pages_in_set = ceil( $this->total_items / $this->items_per_page );

		//Number of links = number of pages - current page (not a link)
		$num_links = $this->number_of_pages - 1;

		if( $num_links > 0 )
		{
			$first_num = $this->current_page - floor( $num_links / 2 ); //Using floor() in case number of pages is an even number, this will round it down
			$last_num = $this->current_page + ceil( $num_links / 2 ); //Using ceil() in case number of pages is an even number, this will round it up
		}

		//If total pages in set is less then desired number of pages to show, use pages 1 through total pages in set
		if ( $this->number_of_pages >= $total_pages_in_set )
		{
			$first_num = 1;
			$last_num = $total_pages_in_set;
			$first = false;
			$prev = false;
			$next = false;
			$last = false;
		}
		//Find the links to show
		else
		{
			while( $last_num > $total_pages_in_set )
			{
				$last_num--;
				$first_num--;
			}

			while( $first_num < 1 )
			{
				$last_num++;
				$first_num++;
			}

			//If Last number to show is the last page in the set, no need for Last Link
			if( $last_num == $total_pages_in_set )
			{
				$last = false;
			}

			//If First number to show is page 1, no need for First Link
			if( $first_num == 1 )
			{
				$first = false;
			}

			//If current page is the first page, there is no previous link to show
			if( $this->current_page == 1 )
			{
				$prev = false;
			}

			//If current page is the last page, there is no Next link to show
			if( $this->current_page == $total_pages_in_set )
			{
				$next = false;
			}
		}

		//Create the pages links
		for( $i = $first_num; $i <= $last_num; $i++ )
		{
			if( $i == $this->current_page )
			{
				$paginate['pages'] .= $this->current_page_wrap_tags['open'] . $i . $this->current_page_wrap_tags['close'];
			}
			else
			{
				$anchor = '<a href="' . $this->pagination_href . '">' . $i . '</a>';

				$anchor = str_replace( $this->replacement_text, $i, $anchor );

				$paginate['pages'] .= $this->numeric_link_wrap_tags['open'] . $anchor . $this->numeric_link_wrap_tags['close'];
			}

			$paginate['pages'] .= $this->page_link_separator;
		}

		//Trim the last added page link separator off the end.
		$paginate['pages'] = trim($paginate['pages'], $this->page_link_separator);

		//Create first link only if First link needs to be created
		if($first)
		{
			$f_anchor = '<a href="' . $this->pagination_href . '">' . $this->first_link_text . '</a>';
			$first_link = str_replace( $this->replacement_text, '1', $f_anchor );
			$paginate['first'] = $this->first_link_wrap_tags['open'] . $first_link . $this->first_link_wrap_tags['close'];	
		}

		//Create last link only if Last link needs to be created
		if($last)
		{
			$l_anchor = '<a href="' . $this->pagination_href . '">' . $this->last_link_text . '</a>';
			$last_link = str_replace( $this->replacement_text, $total_pages_in_set, $l_anchor );
			$paginate['last'] = $this->last_link_wrap_tags['open'] . $last_link . $this->last_link_wrap_tags['close'];
		}
	
		//Create previous link only if Previous link needs to be created
		if($prev)
		{
			$p_anchor = '<a href="' . $this->pagination_href . '">' . $this->previous_link_text . '</a>';
			$prev_link = str_replace( $this->replacement_text, ( $this->current_page - 1 ), $p_anchor );
			$paginate['prev'] = $this->previous_link_wrap_tags['open'] . $prev_link . $this->previous_link_wrap_tags['close'];
		}

		//Create next link only if Next link needs to be created
		if($next)
		{
			$n_anchor = '<a href="' . $this->pagination_href . '">' . $this->next_link_text . '</a>';
			$next_link = str_replace( $this->replacement_text, ( $this->current_page + 1 ), $n_anchor );
			$paginate['next'] = $this->next_link_wrap_tags['open'] . $next_link . $this->next_link_wrap_tags['close'];
		}

		// Return the 5 element array (first, last, prev, next, pages)
		return $paginate;
	}
}
?>
