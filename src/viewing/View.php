<?php
abstract class View {
	public static $title = "Default Title!";
	public static $stylesheets;
	public static $scripts;
	public static $include_foot = true;

	public static function redirect($location, $get_vars = null) {
		$link = null;

		if ($get_vars != null) {
			$link = "?".$get_vars;
		}

		ob_end_clean(); // Destroy buffer
		header("Location: $location.php$link");
		exit();
	}

	public static function make($view)
	{
		if ($view != null) {

				$directory = strpos($view, "/");

				if ($directory === false) {
					$view_path = "../app/views/view.$view.html";
				}else {
					$view_split = str_split($view, $directory+1);
					$view_split[0] = $view_split[0]."view.";
					$view_split[] = ".html";
					$view_path = "../app/views/".implode($view_split);
				}


				if (!file_exists($view_path))
					View::redirect("404");
				else
					require_once($view_path);
				if (static::$include_foot)
					require_once("../app/views/master/view.master.foot.html");
		}
	}

	public static function head() {
		require_once("../app/views/master/view.master.head.html");
	}

	public static function foot() {
		require_once("../app/views/master/view.master.foot.html");
	}

	public function add_style($path) {
		static::$stylesheets .= '<link media="screen" href="css/'.$path.'" rel="stylesheet">'."\n";
	}

	public function add_script($path) {
		static::$scripts .= '<script src="js/'.$path.'" type="text/javascript"></script>'."\n";
	}
}