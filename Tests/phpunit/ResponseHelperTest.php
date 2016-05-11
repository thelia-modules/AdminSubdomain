<?php
/*************************************************************************************/
/*      This file is part of the module AdminSubdomain                               */
/*                                                                                   */
/*      For the full copyright and license information, please view the LICENSE.txt  */
/*      file that was distributed with this source code.                             */
/*************************************************************************************/

namespace AdminSubdomain\Tests\phpunit;

use AdminSubdomain\Helper\ResponseHelper;
use Thelia\Core\HttpFoundation\Request;

/**
 * Class ResponseHelperTest
 * @package AdminSubdomain\Tests
 * @author Gilles Bourgeat <gilles@thelia.net>
 */
class ResponseHelperTest extends \PHPUnit_Framework_TestCase
{
    public function testAddSubdomain()
    {
        $request = Request::create('http://test.thelia.loc/admin/modules', 'GET', [], [], [], [
            'SCRIPT_FILENAME' => '/var/www/web/index.php',
            'SCRIPT_NAME' => '/index.php'
        ]);

        $content = $this->getFixturesBefore('simple');
        $newContent = ResponseHelper::addSubdomain($request, $content, 'test');
        $expectedContent = $this->getFixturesAfter('simple');
        $this->assertEquals($expectedContent, $newContent);
    }

    public function testAddSubdomainWithSubFolder()
    {
        $request = Request::create('http://test.thelia.loc/web/admin/modules', 'GET', [], [], [], [
            'SCRIPT_FILENAME' => '/var/www/web/index.php',
            'SCRIPT_NAME' => '/web/index.php'
        ]);

        $content = $this->getFixturesBefore('with-sub-folder');
        $newContent = ResponseHelper::addSubdomain($request, $content, 'test');
        $expectedContent = $this->getFixturesAfter('with-sub-folder');
        $this->assertEquals($expectedContent, $newContent);
    }

    public function testAddSubdomainWithSubdomain()
    {
        $request = Request::create('http://test.thelia.loc/web/admin/modules', 'GET', [], [], [], [
            'SCRIPT_FILENAME' => '/var/www/web/index.php',
            'SCRIPT_NAME' => '/web/index.php'
        ]);

        $content = $this->getFixturesBefore('with-subdomain');
        $newContent = ResponseHelper::addSubdomain($request, $content, 'test');
        $expectedContent = $this->getFixturesAfter('with-subdomain');
        $this->assertEquals($expectedContent, $newContent);
    }

    public function testAddSubdomainWithComplexSubdomain()
    {
        $request = Request::create('http://admin-test.thelia.loc/web/admin/modules', 'GET', [], [], [], [
            'SCRIPT_FILENAME' => '/var/www/web/index.php',
            'SCRIPT_NAME' => '/web/index.php'
        ]);

        $content = $this->getFixturesBefore('with-complex-subdomain');
        $newContent = ResponseHelper::addSubdomain($request, $content, 'admin-test');
        $expectedContent = $this->getFixturesAfter('with-complex-subdomain');
        $this->assertEquals($expectedContent, $newContent);
    }

    /**
     * @param string $name
     * @return string
     */
    protected function getFixturesBefore($name)
    {
        return file_get_contents(__DIR__ . DS . 'fixtures' . DS . $name . '-before.html');
    }

    /**
     * @param string $name
     * @return string
     */
    protected function getFixturesAfter($name)
    {
        return file_get_contents(__DIR__ . DS . 'fixtures' . DS . $name . '-after.html');
    }
}

