<?php

/**
 * @package  	Simple Duoshuo Disqus Comments - Plugin for Joomla3.X!
 * @author	ngxiaoyi - http://www.ruanjian081.com
 * @copyright	Copyright (c) 2012 - 2013 ruanjian081.com
 * @license	GNU/GPL license: http://www.gnu.org/licenses/gpl-2.0.html
 */
 
defined( '_JEXEC' ) or die( 'Restricted access' );
jimport( 'joomla.plugin.plugin' );

//插件命名规则：plg+插件目录(组别)+无扩展名的插件文件名
class plgContentDuoshuo extends JPlugin {

	function plgContentDuoshuo(&$subject, $params) { 

		parent::__construct($subject, $params); 

		//$mode = $this->params->def('mode', 1);

	}

	function exclude($paramName, $value) {

		$excludeArticlesIds=$this->params->get($paramName);
		$excludeArticlesIdsArray=explode(',', $excludeArticlesIds);
		if(empty($excludeArticlesIdsArray)){
			return 0;
		}
		if(!$value){
			return 0;
		}
		
		if(in_array($value ,$excludeArticlesIdsArray, false)){
			return 1;
		}
		return 0;
	} 
 
	function onContentPrepare( $context, &$article, &$params ) {

		global $mainframe;

		if (($this->exclude('Exclude_Article_Ids',$article->id)==0) AND ($this->exclude('Exclude_Category_Ids',$article->catid)==0)){
			$sect="<br />";
			$sect.='<div style="text-align:center;font-size:80%"><a href="http://www.ruanjian081.com/programe-design/php-language/12-easy-duoshuo-disqus-plugin-for-j30">简易joomla3.X多说评论框插件</a></div>';
			$sect.="<br />";

			$lang =& JFactory::getLanguage();
			$lang_shortcode=explode('-',$lang->getTag());

			if ($this->params->get('Merge_Comments')==0){
				$lang_code="_".$lang_shortcode[0];
			}
			else{
				$lang_code='';
			}

			if( JRequest::getVar( 'view' ) == 'article' ){

				$text='<div class="ds-thread" data-thread-key="'.$article->id.'" data-title="'.$article->title.'"></div>
				<script type="text/javascript">
					var duoshuoQuery = {short_name:"'.$this->params->get('duoshuo_shortname').'"}; // 多说二级域名
					(function() {
						var ds = document.createElement("script"); ds.type = "text/javascript"; ds.async = true;
						ds.src = "http://static.duoshuo.com/embed.js"; ds.charset = "UTF-8";
						(document.getElementsByTagName("head")[0] || document.getElementsByTagName("body")[0]).appendChild(ds);
					})();
				</script>
				<noscript>Please enable JavaScript to view the <a href="http://duoshuo.com/?ref_noscript">disqus comments powered by duoshuo.</noscript>'.$sect;

				$article->text.= $text;

			}
		}
	}
}
?>
