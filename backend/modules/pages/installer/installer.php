<?php

/**
 * Installer for the pages module
 *
 * @package		installer
 * @subpackage	pages
 *
 * @author		Tijs Verkoyen <tijs@netlash.com>
 * @author		Matthias Mullie <matthias@mullie.eu>
 * @author		Dieter Vanden Eynde <dieter@netlash.com>
 * @since		2.0
 */
class PagesInstaller extends ModuleInstaller
{
	/**
	 * Import the data
	 *
	 * @return	void
	 */
	private function importData()
	{
		// insert required pages
		$this->insertPages();

		// install example data if requested
		if($this->installExample()) $this->installExampleData();
	}


	/**
	 * Insert the pages
	 *
	 * @return	void
	 */
	private function insertPages()
	{
		// get extra ids
		$extras['search'] = $this->insertExtra('search', 'block', 'Search', null, null, 'N', 2000);
		$extras['search_form'] = $this->insertExtra('search', 'widget', 'SearchForm', 'form', null, 'N', 2001);
		$extras['sitemap_widget_sitemap'] = $this->insertExtra('pages', 'widget', 'Sitemap', 'sitemap', null, 'N', 1);

		// loop languages
		foreach($this->getLanguages() as $language)
		{
			// check if pages already exist for this language
			if(!(bool) $this->getDB()->getVar('SELECT COUNT(id) FROM pages WHERE language = ?', array($language)))
			{
				// insert homepage
				$this->insertPage(array('id' => 1,
										'parent_id' => 0,
										'template_id' => $this->getTemplateId('home'),
										'title' => 'Home',
										'language' => $language,
										'allow_move' => 'N',
										'allow_delete' => 'N'),
									null,
									array('html' => PATH_WWW . '/backend/modules/pages/installer/data/' . $language . '/sample1.txt'),
									array('extra_id' => $extras['search_form'], 'position' => 'top'));

				// insert sitemap
				$this->insertPage(array('id' => 2,
										'title' => ucfirst($this->getLocale('Sitemap', 'core', $language, 'lbl', 'frontend')),
										'type' => 'footer',
										'language' => $language),
									null,
									array('html' => PATH_WWW . '/backend/modules/pages/installer/data/' . $language . '/sitemap.txt'),
									array('extra_id' => $extras['sitemap_widget_sitemap']),
									array('extra_id' => $extras['search_form'], 'position' => 'top'));

				// insert disclaimer
				$this->insertPage(array('id' => 3,
										'title' => ucfirst($this->getLocale('Disclaimer', 'core', $language, 'lbl', 'frontend')),
										'type' => 'footer',
										'language' => $language),
									array('data' => array('seo_index' => 'noindex', 'seo_follow' => 'nofollow')),
									array('html' => PATH_WWW . '/backend/modules/pages/installer/data/' . $language . '/disclaimer.txt'),
									array('extra_id' => $extras['search_form'], 'position' => 'top'));

				// insert 404
				$this->insertPage(array('id' => 404,
										'title' => '404',
										'type' => 'root',
										'language' => $language,
										'allow_move' => 'N',
										'allow_delete' => 'N'),
									null,
									array('html' => PATH_WWW . '/backend/modules/pages/installer/data/' . $language . '/404.txt'),
									array('extra_id' => $extras['sitemap_widget_sitemap']),
									array('extra_id' => $extras['search_form'], 'position' => 'top'));
			}
		}
	}


	/**
	 * Install this module.
	 *
	 * @return	void
	 */
	public function install()
	{
		// load install.sql
		$this->importSQL(dirname(__FILE__) . '/data/install.sql');

		// add 'pages' as a module
		$this->addModule('pages');

		// import locale
		$this->importLocale(dirname(__FILE__) . '/data/locale.xml');

		// import data
		$this->importData();

		// set rights
		$this->setRights();

		// set navigation
		$this->setNavigation(null, 'Pages', 'pages/index', array('pages/add', 'pages/edit'), 2);

		// settings navigation
		$navigationSettingsId = $this->setNavigation(null, 'Settings');
		$navigationModulesId = $this->setNavigation($navigationSettingsId, 'Modules');
		$this->setNavigation($navigationModulesId, 'Pages', 'pages/settings');
	}


	/**
	 * Install example data
	 *
	 * @return	void
	 */
	private function installExampleData()
	{
		// insert/get extra ids
		$extras['blog_block'] = $this->insertExtra('blog', 'block', 'Blog', null, null, 'N', 1000);
		$extras['blog_widget_recent_comments'] = $this->insertExtra('blog', 'widget', 'RecentComments', 'recent_comments', null, 'N', 1001);
		$extras['blog_widget_categories'] = $this->insertExtra('blog', 'widget', 'Categories', 'categories', null, 'N', 1002);
		$extras['blog_widget_archive'] = $this->insertExtra('blog', 'widget', 'Archive', 'archive', null, 'N', 1003);
		$extras['blog_widget_recent_articles_full'] = $this->insertExtra('blog', 'widget', 'RecentArticlesFull', 'recent_articles_full', null, 'N', 1004);
		$extras['blog_widget_recent_articles_list'] = $this->insertExtra('blog', 'widget', 'RecentArticlesList', 'recent_articles_list', null, 'N', 1005);
		$extras['search'] = $this->insertExtra('search', 'block', 'Search', null, null, 'N', 2000);
		$extras['search_form'] = $this->insertExtra('search', 'widget', 'SearchForm', 'form', null, 'N', 2001);
		$extras['sitemap_widget_sitemap'] = $this->insertExtra('pages', 'widget', 'Sitemap', 'sitemap', null, 'N', 1);

		// loop languages
		foreach($this->getLanguages() as $language)
		{
			// check if pages already exist for this language
			if(!(bool) $this->getDB()->getVar('SELECT COUNT(id) FROM pages WHERE language = ? AND id > ?', array($language, 404)))
			{
				// re-insert homepage
				$this->insertPage(array('id' => 1,
										'parent_id' => 0,
										'template_id' => $this->getTemplateId('home'),
										'title' => 'Home',
										'language' => $language,
										'allow_move' => 'N',
										'allow_delete' => 'N'),
									null,
									array('html' => PATH_WWW . '/backend/modules/pages/installer/data/' . $language . '/sample1.txt'),
									array('extra_id' => $extras['blog_widget_recent_articles_list'], 'position' => 'left'),
									array('extra_id' => $extras['blog_widget_recent_comments'], 'position' => 'right'),
									array('extra_id' => $extras['search_form'], 'position' => 'top'));

				// insert blog
				$this->insertPage(array('title' => 'Blog',
										'language' => $language),
									null,
									array('extra_id' => $extras['blog_block']),
									array('extra_id' => $extras['blog_widget_recent_comments'], 'position' => 'left'),
									array('extra_id' => $extras['blog_widget_categories'], 'position' => 'left'),
									array('extra_id' => $extras['blog_widget_archive'], 'position' => 'left'),
									array('extra_id' => $extras['blog_widget_recent_articles_list'], 'position' => 'left'),
									array('extra_id' => $extras['search_form'], 'position' => 'top'));

				// insert about us page
				$aboutUsId = $this->insertPage(array('title' => ucfirst($this->getLocale('AboutUs', 'core', $language, 'lbl', 'frontend')),
														'parent_id' => 1,
														'language' => $language),
														null,
														array('extra_id' => $extras['search_form'], 'position' => 'top'));

				// location
				$this->insertPage(array('title' => ucfirst($this->getLocale('Location', 'core', $language, 'lbl', 'frontend')),
										'parent_id' => $aboutUsId,
										'language' => $language),
									null,
									array('html' => PATH_WWW . '/backend/modules/pages/installer/data/' . $language . '/sample1.txt'),
									array('html' => PATH_WWW . '/backend/modules/pages/installer/data/' . $language . '/sample2.txt'),
									array('extra_id' => $extras['search_form'], 'position' => 'top'));

				// team
				$this->insertPage(array('title' => 'Team',
										'parent_id' => $aboutUsId,
										'language' => $language),
									null,
									array('html' => PATH_WWW . '/backend/modules/pages/installer/data/' . $language . '/sample1.txt'),
									array('html' => PATH_WWW . '/backend/modules/pages/installer/data/' . $language . '/sample2.txt'),
									array('extra_id' => $extras['search_form'], 'position' => 'top'));

				// history
				$this->insertPage(array('title' => ucfirst($this->getLocale('History', 'core', $language, 'lbl', 'frontend')),
										'parent_id' => 1,
										'language' => $language),
									null,
									array('html' => PATH_WWW . '/backend/modules/pages/installer/data/' . $language . '/sample1.txt'),
									array('html' => PATH_WWW . '/backend/modules/pages/installer/data/' . $language . '/sample2.txt'),
									array('extra_id' => $extras['search_form'], 'position' => 'top'));

				// insert lorem ipsum test page
				$this->insertPage(array('title' => 'Lorem ipsum',
										'type' => 'root',
										'language' => $language,
										'hidden' => 'Y'),
									array('data' => array('seo_index' => 'noindex', 'seo_follow' => 'nofollow')),
									array('html' => PATH_WWW . '/backend/modules/pages/installer/data/' . $language . '/lorem_ipsum.txt'),
									array('extra_id' => $extras['search_form'], 'position' => 'top'));
			}
		}
	}


	/**
	 * Set the rights
	 *
	 * @return	void
	 */
	private function setRights()
	{
		// module rights
		$this->setModuleRights(1, 'pages');

		// action rights
		$this->setActionRights(1, 'pages', 'get_info');
		$this->setActionRights(1, 'pages', 'move');

		$this->setActionRights(1, 'pages', 'index');
		$this->setActionRights(1, 'pages', 'add');
		$this->setActionRights(1, 'pages', 'delete');
		$this->setActionRights(1, 'pages', 'edit');

		$this->setActionRights(1, 'pages', 'settings');
	}
}

?>