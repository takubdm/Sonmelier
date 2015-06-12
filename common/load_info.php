<?php

/*
	$dbl = DbLoader::getInstance();
	$x = $dbl->exec_func_chain(
		array(
			array('func' => 'get_list_infos', 'arg' => array())
		)
	);
	var_dump($x);
*/

	class DbLoader
	{
		//Private and Static variables
        private static $instance;
		private static $mysql;

		//Singleton functions
        private function __construct()
        {
        	self::$mysql = array(
				'link' => null,
				'server' => 'localhost',
				'username' => 'root',
				'password' => 'ventretky',
				'db' => 'music_list',
				'table' => array(
					'load' => array(
						'category' => 'view_category',
						'list_infos' => 'view_list',
						'current_list_info' => 'view_artist_info'
					),
					'create' => 'list',
					'remove' => 'list'
				)
			);
        }
		public static function getInstance()
		{
			if (!isset(self::$instance))
			{
				self::$instance = new DbLoader();
			}
			return self::$instance;
		}
        public final function __clone()
        {
			throw new RuntimeException('Cloning this instance is prohibited.' . get_class($this));
        }

		//Public functions
		public function exec_func_chain($chain)
		{
			$dump = array();
			$chain = self::get_arrayed($chain);
			foreach($chain as $func)
			{
				$func_name = 'self::'.$func['name'];
				$func_arg = self::get_arrayed($func['arg']);
				$dump = array_merge($dump, call_user_func_array($func_name, $func_arg));
			}
			return $dump;
		}
		public function get_array($arr, $key)
		{
			$list = array();
			foreach ($arr as $nthlist)
			{
				$list[] = $nthlist[$key];
			}
			return $list;
		}

		//Private functions
		private function create_list($posted_values)
		{
			/*
			$posted_values is an array and contains the following keys;
				- list_name
				- title
				- url
				- is_shuffle
				- category_name
				- artists
			*/

			//Select database
			$mysql = self::get_mysql();
			$mysql['link'] = mysqli_connect($mysql['server'], $mysql['username'], $mysql['password']);
			mysqli_select_db($mysql['link'], 'music_list');

			//Define alias
			$pv = self::mysql_escape($mysql['link'], $posted_values);

			/*
			Arguments for `create_list` of mysql should be passed in the following order;

			call create_list(
				list_name,
				title,
				url,
				is_shuffle (0/1 for false/true)
				category_name,
				artists
			);
			*/
			/*
			Exec query

			In order to guarantee the order of arguments $query is defined manually, not using function like `implode`.
			*/
			$dump = array();
			$query = "call create_list(".
				"'".$pv['list_name']."', ".
				"'".$pv['title']."', ".
				"'".$pv['url']."', ".
				" ".$pv['is_shuffle']." , ".
				"'".$pv['category_name']."', ".
				"'".$pv['artists']."'".
			");";
			$result = mysqli_query($mysql['link'], $query);
			$result = mysqli_fetch_assoc($result);
			$dump['status'] = $result['status'];
			$dump['result'] = $result['result'];

			//Terminate
			mysqli_close($mysql['link']);
			return $dump;
		}
		private function edit_list($posted_values)
		{
			/*
			$posted_values is an array and contains the following keys;
				- list_name
				- title
				- url
				- is_shuffle
				- category_name
				- artists
			*/

			//Select database
			$mysql = self::get_mysql();
			$mysql['link'] = mysqli_connect($mysql['server'], $mysql['username'], $mysql['password']);
			mysqli_select_db($mysql['link'], 'music_list');

			//Define alias
			$pv = self::mysql_escape($mysql['link'], $posted_values);

			/*
			Arguments for `create_list` of mysql should be passed in the following order;

			call edit_list(
				list_id,
				list_name,
				title,
				url,
				is_shuffle (0/1 for false/true)
				category_name,
				artists
			);
			*/
			/*
			Exec query

			In order to guarantee the order of arguments $query is defined manually, not using function like `implode`.
			*/
			$dump = array();
			$query = "call edit_list(".
				"'".$pv['list_id']."', ".
				"'".$pv['list_name']."', ".
				"'".$pv['title']."', ".
				"'".$pv['url']."', ".
				" ".$pv['is_shuffle']." , ".
				"'".$pv['category_name']."', ".
				"'".$pv['artists']."'".
			");";
			$result = mysqli_query($mysql['link'], $query);
			$result = mysqli_fetch_assoc($result);
			$dump['status'] = $result['status'];
			$dump['result'] = $result['result'];

			//Terminate
			mysqli_close($mysql['link']);
			return $dump;
		}
		private function remove_list($list_id)
		{
			//Select database
			$mysql = self::get_mysql();
			$mysql['link'] = mysqli_connect($mysql['server'], $mysql['username'], $mysql['password']);
			mysqli_select_db($mysql['link'], 'music_list');

			//Exec query
			$dump = array();
			$query = "call remove_list(".$list_id.");";
			$result = mysqli_query($mysql['link'], $query);
			$result = mysqli_fetch_assoc($result);
			$dump['status'] = $result['status'];
			$dump['result'] = $result['result'];

			//Terminate
			mysqli_close($mysql['link']);
			return $dump;
		}
		private function get_current_list_info($list_id)
		{
			$mysql = self::get_mysql();
			$mysql['link'] = mysqli_connect($mysql['server'], $mysql['username'], $mysql['password']);
			mysqli_select_db($mysql['link'], 'music_list');
			//
			$dump = array('current_list' => array('info' => null, 'artists' => array()));
			//
			$query = "select * from ".$mysql['table']['load']['list_infos'].' where `ID_List` = '.$list_id.';';
			$result = mysqli_query($mysql['link'], $query);
			//
			while ($row = mysqli_fetch_assoc($result))
			{
				$dump['current_list']['info'] = $row;
			}
			//
			$result = mysqli_query($mysql['link'], "select * from ".$mysql['table']['load']['current_list_info'].' where `ID_List` = '.$list_id.';');
			//
			while ($row = mysqli_fetch_assoc($result))
			{
				$dump['current_list']['artists'][] = $row;
			}
			//
			mysqli_close($mysql['link']);
			return $dump;
		}
		private function get_list_infos()
		{
			$mysql = self::get_mysql();
			$mysql['link'] = mysqli_connect($mysql['server'], $mysql['username'], $mysql['password']);
			mysqli_select_db($mysql['link'], 'music_list');
			//
			$dump = array('list_infos' => array());
			$result = mysqli_query($mysql['link'], "select * from ".$mysql['table']['load']['list_infos'].' order by `ID_Category` ASC, `Name` ASC;');
			//
			while ($row = mysqli_fetch_assoc($result))
			{
				$dump['list_infos'][] = $row;
			}
			//
			mysqli_close($mysql['link']);
			return $dump;
		}
		private function get_category_list()
		{
			$mysql = self::get_mysql();
			$mysql['link'] = mysqli_connect($mysql['server'], $mysql['username'], $mysql['password']);
			mysqli_select_db($mysql['link'], 'music_list');
			//
			$dump = array('category' => array());
			$result = mysqli_query($mysql['link'], "select * from ".$mysql['table']['load']['category'].';');
			//
			while ($row = mysqli_fetch_assoc($result))
			{
				$dump['category'][] = $row;
			}
			//
			mysqli_close($mysql['link']);
			return $dump;
		}
		private function mysql_escape($link_id, $arr)
		{
			$escaped_values = array();
			foreach ($arr as $key => $value)
			{
				$escaped_values[$key] = mysqli_real_escape_string($link_id, $value);
			}
			return $escaped_values;
		}
		private function get_arrayed($arg)
		{
			$arg = is_array($arg) ? $arg : array($arg);
			return (in_array('0', array_keys($arg))) ? $arg : array($arg);
		}
		private static function get_mysql()
		{
			return self::$mysql;
		}
	}
?>