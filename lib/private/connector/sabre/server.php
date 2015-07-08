<?php
/**
 * @author Morris Jobke <hey@morrisjobke.de>
 * @author scolebrook <scolebrook@mac.com>
 * @author Thomas Müller <thomas.mueller@tmit.eu>
 * @author Vincent Petry <pvince81@owncloud.com>
 *
 * @copyright Copyright (c) 2015, ownCloud, Inc.
 * @license AGPL-3.0
 *
 * This code is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License, version 3,
 * as published by the Free Software Foundation.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU Affero General Public License for more details.
 *
 * You should have received a copy of the GNU Affero General Public License, version 3,
 * along with this program.  If not, see <http://www.gnu.org/licenses/>
 *
 */

namespace OC\Connector\Sabre;

/**
 * Class \OC\Connector\Sabre\Server
 *
 * This class overrides some methods from @see \Sabre\DAV\Server.
 *
 * @see \Sabre\DAV\Server
 */
class Server extends \Sabre\DAV\Server {

	/**
	 * @var string
	 */
	private $overLoadedUri = null;

	/**
	 * @var boolean
	 */
	private $ignoreRangeHeader = false;

	public function getRequestUri() {

		if (!is_null($this->overLoadedUri)) {
			return $this->overLoadedUri;
		}

		return parent::getRequestUri();
	}

	public function checkPreconditions($handleAsGET = false) {
		// chunked upload handling
		if (isset($_SERVER['HTTP_OC_CHUNKED'])) {
			$filePath = parent::getRequestUri();
			list($path, $name) = \Sabre\DAV\URLUtil::splitPath($filePath);
			$info = OC_FileChunking::decodeName($name);
			if (!empty($info)) {
				$filePath = $path . '/' . $info['name'];
				$this->overLoadedUri = $filePath;
			}
		}

		$result = parent::checkPreconditions($handleAsGET);
		$this->overLoadedUri = null;
		return $result;
	}

	public function getHTTPRange() {
		if ($this->ignoreRangeHeader) {
			return null;
		}
		return parent::getHTTPRange();
	}

	protected function httpGet($uri) {
		$range = $this->getHTTPRange();

		if (OC_App::isEnabled('files_encryption') && $range) {
			// encryption does not support range requests
			$this->ignoreRangeHeader = true;	
		}
		return parent::httpGet($uri);
	}

	/**
	 * @see \Sabre\DAV\Server
	 */
	public function __construct($treeOrNode = null) {
		parent::__construct($treeOrNode);
		self::$exposeVersion = false;
		$this->enablePropfindDepthInfinity = true;
	}
}
