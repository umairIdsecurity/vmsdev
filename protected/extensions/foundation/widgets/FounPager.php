<?php
/**
 * FounPager class file.
 * @author Alex Urbano <asgaroth.belem@gmail.com>
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 * @package foundation.widgets
 */

/**
 * Foundation pager widget.
 */
class FounPager extends CLinkPager
{
	/**
	 * @var boolean whether to display the first and last items.
	 */
	public $displayFirstAndLast = false;

	/**
	 * Initializes the pager by setting some default property values.
	 */
	public function init()
	{
		if ($this->header === null)
			$this->header = ''; // Foundation does not use a header

		if ($this->cssFile === null)
			$this->cssFile = false; // Foundation has its own css
		
		if ($this->prevPageLabel === null)
            $this->prevPageLabel='&laquo;';
        
        if ($this->nextPageLabel === null)
            $this->nextPageLabel='&raquo;';
        
        if($this->firstPageLabel===null)
            $this->firstPageLabel=Yii::t('yii','&laquo;&laquo;');
        
        if($this->lastPageLabel===null)
            $this->lastPageLabel=Yii::t('yii','&raquo;&raquo;');
			

		if (!isset($this->htmlOptions['class']))
			$this->htmlOptions['class'] = 'pagination'; // would default to yiiPager

		parent::init();
	}

	/**
	 * Creates the page buttons.
	 * @return array a list of page buttons (in HTML code).
	 */
	protected function createPageButtons()
	{
		if (($pageCount = $this->getPageCount()) <= 1)
			return array();

		list ($beginPage, $endPage) = $this->getPageRange();

		$currentPage = $this->getCurrentPage(false); // currentPage is calculated in getPageRange()

		$buttons = array();

		// first page
		if ($this->displayFirstAndLast)
			$buttons[] = $this->createPageButton($this->firstPageLabel, 0, 'first', $currentPage <= 0, false);

		// prev page
		if (($page = $currentPage - 1) < 0)
			$page = 0;

		$buttons[] = $this->createPageButton($this->prevPageLabel, $page, 'previous', $currentPage <= 0, false);

		// internal pages
		for ($i = $beginPage; $i <= $endPage; ++$i)
			$buttons[] = $this->createPageButton($i + 1, $i, '', false, $i == $currentPage);

		// next page
		if (($page = $currentPage+1) >= $pageCount-1)
			$page = $pageCount-1;

		$buttons[] = $this->createPageButton($this->nextPageLabel, $page, 'next', $currentPage >= ($pageCount - 1), false);

		// last page
		if ($this->displayFirstAndLast)
			$buttons[] = $this->createPageButton($this->lastPageLabel, $pageCount - 1, 'last', $currentPage >= ($pageCount - 1), false);

		return $buttons;
	}

	/**
	 * Creates a page button.
	 * You may override this method to customize the page buttons.
	 * @param string $label the text label for the button
	 * @param integer $page the page number
	 * @param string $class the CSS class for the page button. This could be 'page', 'first', 'last', 'next' or 'previous'.
	 * @param boolean $hidden whether this page button is visible
	 * @param boolean $selected whether this page button is selected
	 * @return string the generated button
	 */
	protected function createPageButton($label, $page, $class, $hidden, $selected)
	{
		if ($hidden || $selected)
			$class .= ' '.($hidden ? 'unavailable' : 'current');

		return CHtml::tag('li', array('class'=>$class), CHtml::link($label, $this->createPageUrl($page)));
	}
}
