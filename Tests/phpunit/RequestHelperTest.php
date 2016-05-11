<?php
/*************************************************************************************/
/*      This file is part of the module AdminSubdomain                               */
/*                                                                                   */
/*      For the full copyright and license information, please view the LICENSE.txt  */
/*      file that was distributed with this source code.                             */
/*************************************************************************************/

namespace AdminSubdomain\Tests\phpunit;

use AdminSubdomain\Helper\RequestHelper;

/**
 * Class RequestHelperTest
 * @package AdminSubdomain\Tests
 * @author Gilles Bourgeat <gilles@thelia.net>
 */
class RequestHelperTest extends \PHPUnit_Framework_TestCase
{
    public function testExtractSubdomains()
    {
        $testArray = array(
            'sub1.sub2.example.co.uk' => 'sub1.sub2',
            'sub1.example.com' => 'sub1',
            'example.com' => '',
            'sub1.sub2.sub3.example.co.uk' => 'sub1.sub2.sub3',
            'sub1.sub2.sub3.example.com' => 'sub1.sub2.sub3',
            'sub1.sub2.example.com' => 'sub1.sub2',
            'http://sub1.sub2.example.com' => 'sub1.sub2',
            'https://sub1.sub2.example.com' => 'sub1.sub2',
            'https://sub1.sub2.example.com/web/index.php/test?test=test' => 'sub1.sub2'
        );

        foreach ($testArray as $host => $expected) {
            $this->assertEquals($expected, RequestHelper::extractSubdomain($host));
        }
    }

    public function testExtractDomains()
    {
        $testArray = array(
            'sub1.sub2.example.co.uk' => 'example.co.uk',
            'sub1.example.com' => 'example.com',
            'example.com' => 'example.com',
            'sub1.sub2.sub3.example.co.uk' => 'example.co.uk',
            'sub1.sub2.sub3.example.com' => 'example.com',
            'sub1.sub2.example.com' => 'example.com',
            'http://sub1.sub2.example.com' => 'example.com',
            'https://sub1.sub2.example.com' => 'example.com',
            'https://sub1.sub2.example.com/web/index.php/test?test=test' => 'example.com'
        );

        foreach ($testArray as $host => $expected) {
            $this->assertEquals($expected, RequestHelper::extractDomain($host));
        }
    }

    public function testExtractHosts()
    {
        $testArray = array(
            'sub1.sub2.example.co.uk' => 'sub1.sub2.example.co.uk',
            'sub1.example.com' => 'sub1.example.com',
            'example.com' => 'example.com',
            'sub1.sub2.sub3.example.co.uk' => 'sub1.sub2.sub3.example.co.uk',
            'sub1.sub2.sub3.example.com' => 'sub1.sub2.sub3.example.com',
            'sub1.sub2.example.com' => 'sub1.sub2.example.com',
            'http://sub1.sub2.example.com' => 'sub1.sub2.example.com',
            'https://sub1.sub2.example.com' => 'sub1.sub2.example.com',
            'https://sub1.sub2.example.com/web/index.php/test?test=test' => 'sub1.sub2.example.com'
        );

        foreach ($testArray as $host => $expected) {
            $this->assertEquals($expected, RequestHelper::extractHost($host));
        }
    }
}
