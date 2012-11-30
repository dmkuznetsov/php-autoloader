<?php
/**
 * ClassMap
 *
 * This library is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation; either
 * version 3 of the License, or (at your option) any later version.
 *
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 * @copyright (c) 2012, Dmitry Kuznetsov <dev.kuznetsov@gmail.com>. All rights reserved.
 * @author Dmitry Kuznetsov <dev.kuznetsov@gmail.com>
 * @url https://github.com/dmkuznetsov/php-class-map
*/
class ClassMap_Progress_Console extends ClassMap_Progress
{
	private $_status = false;
	private $_count;
	private $_state = 0;
	const MIN_FOR_RULE = 25;

	public function start( $count = null )
	{
		if ( !is_null( $count ) && $count >= self::MIN_FOR_RULE )
		{
			$this->_showRule();
		}
		$this->_status = true;
		$this->_count = $count;
		$this->_state = 0;
	}

	public function update( $number = 0 )
	{
		if ( is_null( $this->_count ) )
		{
			$this->_updateUnlimited();
		}
		else
		{
			$this->_updateLimited( $number );
		}
	}

	public function stop()
	{
		$this->_status = false;
		$this->_state = 0;
	}

	private function _updateUnlimited()
	{
		list( $micro, ) = explode( ' ', microtime() );
		$micro *= 100;
		if ( !$this->_state || $micro > $this->_state + 5 )
		{
			$this->_state = $micro;
			echo ".";
		}
	}

	private function _updateLimited( $number )
	{
		if ( $this->_count >= self::MIN_FOR_RULE )
		{
			$percent = (int) ($number * 100 / $this->_count );
			if ( $percent % 2 && $percent >= $this->_state + 2 )
			{
				$this->_state = $percent;
				echo "=";
			}
		}
	}

	private function _showRule()
	{
		$length = 50;
		$hint = "100%";
		$content = "\n[";
		for ( $i = 0, $c = $length - strlen( $hint ); $i < $c; $i++ )
		{
			if ( $i == $c / 2 - strlen( $hint ) / 2 )
			{
				$content .= $hint;
			}
			else
			{
				$content .= "-";
			}
		}
		$content .= "]\n ";
		echo $content;
	}
}