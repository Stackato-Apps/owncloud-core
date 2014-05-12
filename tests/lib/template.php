<?php
/**
* ownCloud
*
* @author Bernhard Posselt
* @copyright 2012 Bernhard Posselt nukeawhale@gmail.com
*
* This library is free software; you can redistribute it and/or
* modify it under the terms of the GNU AFFERO GENERAL PUBLIC LICENSE
* License as published by the Free Software Foundation; either
* version 3 of the License, or any later version.
*
* This library is distributed in the hope that it will be useful,
* but WITHOUT ANY WARRANTY; without even the implied warranty of
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
* GNU AFFERO GENERAL PUBLIC LICENSE for more details.
*
* You should have received a copy of the GNU Affero General Public
* License along with this library.  If not, see <http://www.gnu.org/licenses/>.
*
*/

class Test_TemplateFunctions extends PHPUnit_Framework_TestCase {

	public function setUp() {
		$loader = new \OC\Autoloader();
		$loader->load('OC_Template');
	}

	public function testP() {
		// FIXME: do we need more testcases?
		$htmlString = "<script>alert('xss');</script>";
		ob_start();
		p($htmlString);
		$result = ob_get_clean();

		$this->assertEquals("&lt;script&gt;alert(&#039;xss&#039;);&lt;/script&gt;", $result);
	}

	public function testPNormalString() {
		$normalString = "This is a good string!";
		ob_start();
		p($normalString);
		$result = ob_get_clean();

		$this->assertEquals("This is a good string!", $result);
	}

	public function testPrintUnescaped() {
		$htmlString = "<script>alert('xss');</script>";

		ob_start();
		print_unescaped($htmlString);
		$result = ob_get_clean();

		$this->assertEquals($htmlString, $result);
	}

	public function testPrintUnescapedNormalString() {
		$normalString = "This is a good string!";
		ob_start();
		print_unescaped($normalString);
		$result = ob_get_clean();

		$this->assertEquals("This is a good string!", $result);
	}

	// ---------------------------------------------------------------------------
	// Test relative_modified_date with dates only
	// ---------------------------------------------------------------------------
	public function testRelativeDateToday(){
		$currentTime = 1380703592;
		$elementTime = $currentTime;
		$result = (string)relative_modified_date($elementTime, $currentTime, true);

		$this->assertEquals('today', $result);

		// 2 hours ago is still today
		$elementTime = $currentTime - 2 * 3600;
		$result = (string)relative_modified_date($elementTime, $currentTime, true);

		$this->assertEquals('today', $result);
	}

	public function testRelativeDateYesterday(){
		$currentTime = 1380703592;
		$elementTime = $currentTime - 24 * 3600;
		$result = (string)relative_modified_date($elementTime, $currentTime, true);

		$this->assertEquals('yesterday', $result);

		// yesterday - 2 hours is still yesterday
		$elementTime = $currentTime - 26 * 3600;
		$result = (string)relative_modified_date($elementTime, $currentTime, true);

		$this->assertEquals('yesterday', $result);
	}

	public function testRelativeDate2DaysAgo(){
		$currentTime = 1380703592;
		$elementTime = $currentTime - 48 * 3600;
		$result = (string)relative_modified_date($elementTime, $currentTime, true);

		$this->assertEquals('2 days ago', $result);

		// 2 days ago minus 4 hours is still 2 days ago
		$elementTime = $currentTime - 52 * 3600;
		$result = (string)relative_modified_date($elementTime, $currentTime, true);

		$this->assertEquals('2 days ago', $result);
	}

	public function testRelativeDateLastMonth(){
		$currentTime = 1380703592;
		$elementTime = $currentTime - 86400 * 31;
		$result = (string)relative_modified_date($elementTime, $currentTime, true);

		$this->assertEquals('last month', $result);

		$elementTime = $currentTime - 86400 * 35;
		$result = (string)relative_modified_date($elementTime, $currentTime, true);

		$this->assertEquals('last month', $result);
	}

	public function testRelativeDateMonthsAgo(){
		$currentTime = 1380703592;
		$elementTime = $currentTime - 86400 * 60;
		$result = (string)relative_modified_date($elementTime, $currentTime, true);

		$this->assertEquals('2 months ago', $result);

		$elementTime = $currentTime - 86400 * 65;
		$result = (string)relative_modified_date($elementTime, $currentTime, true);

		$this->assertEquals('2 months ago', $result);
	}

	public function testRelativeDateLastYear(){
		$currentTime = 1380703592;
		$elementTime = $currentTime - 86400 * 365;
		$result = (string)relative_modified_date($elementTime, $currentTime, true);

		$this->assertEquals('last year', $result);

		$elementTime = $currentTime - 86400 * 450;
		$result = (string)relative_modified_date($elementTime, $currentTime, true);

		$this->assertEquals('last year', $result);
	}

	public function testRelativeDateYearsAgo(){
		$currentTime = 1380703592;
		$elementTime = $currentTime - 86400 * 365.25 * 2;
		$result = (string)relative_modified_date($elementTime, $currentTime, true);

		$this->assertEquals('years ago', $result);

		$elementTime = $currentTime - 86400 * 365.25 * 3;
		$result = (string)relative_modified_date($elementTime, $currentTime, true);

		$this->assertEquals('years ago', $result);
	}

	// ---------------------------------------------------------------------------
	// Test relative_modified_date with timestamps only (date + time value)
	// ---------------------------------------------------------------------------

	public function testRelativeTimeSecondsAgo(){
		$currentTime = 1380703592;
		$elementTime = $currentTime - 5;
		$result = (string)relative_modified_date($elementTime, $currentTime, false);

		$this->assertEquals('seconds ago', $result);
	}

	public function testRelativeTimeMinutesAgo(){
		$currentTime = 1380703592;
		$elementTime = $currentTime - 190;
		$result = (string)relative_modified_date($elementTime, $currentTime, false);

		$this->assertEquals('3 minutes ago', $result);
	}

	public function testRelativeTimeHoursAgo(){
		$currentTime = 1380703592;
		$elementTime = $currentTime - 7500;
		$result = (string)relative_modified_date($elementTime, $currentTime, false);

		$this->assertEquals('2 hours ago', $result);
	}

	public function testRelativeTime2DaysAgo(){
		$currentTime = 1380703592;
		$elementTime = $currentTime - 48 * 3600;
		$result = (string)relative_modified_date($elementTime, $currentTime, false);

		$this->assertEquals('2 days ago', $result);

		// 2 days ago minus 4 hours is still 2 days ago
		$elementTime = $currentTime - 52 * 3600;
		$result = (string)relative_modified_date($elementTime, $currentTime, false);

		$this->assertEquals('2 days ago', $result);
	}

	public function testRelativeTimeLastMonth(){
		$currentTime = 1380703592;
		$elementTime = $currentTime - 86400 * 31;
		$result = (string)relative_modified_date($elementTime, $currentTime, false);

		$this->assertEquals('last month', $result);

		$elementTime = $currentTime - 86400 * 35;
		$result = (string)relative_modified_date($elementTime, $currentTime, false);

		$this->assertEquals('last month', $result);
	}

	public function testRelativeTimeMonthsAgo(){
		$currentTime = 1380703592;
		$elementTime = $currentTime - 86400 * 60;
		$result = (string)relative_modified_date($elementTime, $currentTime, false);

		$this->assertEquals('2 months ago', $result);

		$elementTime = $currentTime - 86400 * 65;
		$result = (string)relative_modified_date($elementTime, $currentTime, false);

		$this->assertEquals('2 months ago', $result);
	}

	public function testRelativeTimeLastYear(){
		$currentTime = 1380703592;
		$elementTime = $currentTime - 86400 * 365;
		$result = (string)relative_modified_date($elementTime, $currentTime, false);

		$this->assertEquals('last year', $result);

		$elementTime = $currentTime - 86400 * 450;
		$result = (string)relative_modified_date($elementTime, $currentTime, false);

		$this->assertEquals('last year', $result);
	}

	public function testRelativeTimeYearsAgo(){
		$currentTime = 1380703592;
		$elementTime = $currentTime - 86400 * 365.25 * 2;
		$result = (string)relative_modified_date($elementTime, $currentTime, false);

		$this->assertEquals('years ago', $result);

		$elementTime = $currentTime - 86400 * 365.25 * 3;
		$result = (string)relative_modified_date($elementTime, $currentTime, false);

		$this->assertEquals('years ago', $result);
	}
}
