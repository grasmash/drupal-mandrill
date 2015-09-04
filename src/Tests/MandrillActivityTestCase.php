<?php
namespace Drupal\mandrill\Tests;

/**
 * Tests Mandrill Activity functionality.
 * 
 * @group mandrill
 */
class MandrillActivityTestCase extends \Drupal\simpletest\WebTestBase {

  protected $profile = 'standard';

  /**
   * Returns info displayed in the test interface.
   *
   * @return array
   *   Formatted as specified by simpletest.
   */
  public static function getInfo() {
    // Note: getInfo() strings are not translated with t().
    return [
      'name' => 'Mandrill Activity Tests',
      'description' => 'Tests Mandrill Activity functionality.',
      'group' => 'Mandrill',
    ];
  }

  /**
   * Pre-test setup function.
   *
   * Enables dependencies.
   * Sets the mandrill_api_key variable to the test key.
   */
  protected function setUp() {
    // Use a profile that contains required modules:
    $prof = drupal_get_profile();
    $this->profile = $prof;
    // Enable modules required for the test.
    $enabled_modules = [
      'libraries',
      'mandrill',
      'mandrill_activity',
      'entity',
    ];
    parent::setUp($enabled_modules);
    \Drupal::config('mandrill.settings')->set('mandrill_api_classname', 'DrupalMandrillTest')->save();
    \Drupal::config('mandrill.settings')->set('mandrill_api_key', 'MANDRILL_TEST_API_KEY')->save();
  }

  /**
   * Post-test function.
   *
   * Sets test mode to FALSE.
   */
  protected function tearDown() {
    parent::tearDown();

    \Drupal::config('mandrill.settings')->clear('mandrill_api_classname')->save();
    \Drupal::config('mandrill.settings')->clear('mandrill_api_key')->save();
  }

  /**
   * Tests getting an array of message activity for a given email address.
   */
  public function testGetActivity() {
    $email = 'recipient@example.com';

    $activity = mandrill_activity_get_activity($email);

    $this->assertTrue(!empty($activity), 'Tested retrieving activity.');

    if (!empty($activity) && is_array($activity)) {
      foreach ($activity as $message) {
        $this->assertEqual($message['email'], $email, 'Tested valid message: ' . $message['subject']);
      }
    }
  }

}