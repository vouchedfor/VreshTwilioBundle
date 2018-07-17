<?php
namespace Vresh\TwilioBundle\Tests\DependencyInjection;

use Symfony\Component\Yaml\Parser;
use Vresh\TwilioBundle\DependencyInjection\Configuration;
/**
 * Test the configuration tree
 *
 * @author Fridolin Koch <info@fridokoch.de>
 *
 */
class ConfigurationTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function testGetConfigTreeBuilder()
    {
        $config = new Configuration();
        /** @var \Symfony\Component\Config\Definition\ArrayNode $node  */
        $tree = $config->getConfigTreeBuilder()->buildTree();
        //check root name
        $this->assertEquals('twilio', $tree->getName());
        //get child nodes and check them
        /** @var \Symfony\Component\Config\Definition\ScalarNode[] $children  */
        $children = $tree->getChildren();
        //check length
        $this->assertEquals(2, count($children));
        //check if all config values are available
        $this->assertArrayHasKey('sid', $children);
        $this->assertArrayHasKey('authToken', $children);
    }

    /**
     * @test
     */
    public function testYamlFile()
    {
        $yaml = new Parser();
        $config = $yaml->parse(file_get_contents(realpath(__DIR__ . '/../../Resources/config/services.yml')));
        //validate config
        $this->assertArrayHasKey('services', $config);
        $this->assertArrayHasKey('twilio.client', $config['services']);
        $this->assertArrayHasKey('class', $config['services']['twilio.client']);
    }
}
