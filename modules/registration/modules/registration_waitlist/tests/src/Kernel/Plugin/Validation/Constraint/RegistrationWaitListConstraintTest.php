<?php

namespace Drupal\Tests\registration_waitlist\Kernel\Plugin\Validation\Constraint;

use Drupal\user\UserInterface;
use Drupal\Tests\registration\Traits\NodeCreationTrait;
use Drupal\Tests\registration\Traits\RegistrationCreationTrait;
use Drupal\Tests\registration_waitlist\Kernel\RegistrationWaitListKernelTestBase;

/**
 * Tests the wait list extended Registration constraint.
 *
 * @coversDefaultClass \Drupal\registration_waitlist\Plugin\Validation\Constraint\RegistrationConstraint
 *
 * @group registration
 */
class RegistrationWaitListConstraintTest extends RegistrationWaitListKernelTestBase {

  use NodeCreationTrait;
  use RegistrationCreationTrait;

  /**
   * The admin user.
   *
   * @var \Drupal\user\UserInterface
   */
  protected UserInterface $adminUser;

  /**
   * {@inheritdoc}
   */
  protected function setUp(): void {
    parent::setUp();

    $admin_user = $this->createUser();
    $this->setCurrentUser($admin_user);
    $this->adminUser = $admin_user;
  }

  /**
   * @covers ::validate
   */
  public function testWaitListRegistrationConstraint() {
    $node = $this->createAndSaveNode();

    // Fill the regular capacity.
    $active_registration = $this->createRegistration($node);
    $active_registration->set('author_uid', 1);
    $active_registration->set('count', 5);
    $active_registration->save();

    // Add to the wait list.
    $registration = $this->createRegistration($node);
    $registration->set('author_uid', 1);
    $registration->set('count', 5);
    $violations = $registration->validate();
    $this->assertEquals(0, $violations->count());
    $registration->save();
    $this->assertEquals('waitlist', $registration->getState()->id());

    $registration = $this->createRegistration($node);
    $registration->set('author_uid', 1);
    $registration->set('count', 5);
    $violations = $registration->validate();
    $this->assertEquals(0, $violations->count());
    $registration->save();
    $this->assertEquals('waitlist', $registration->getState()->id());

    // No more room on the wait list.
    $registration2 = $this->createRegistration($node);
    $registration2->set('author_uid', 1);
    $violations = $registration2->validate();
    $this->assertEquals('Sorry, unable to register for %label because the wait list is full.', (string) $violations[0]->getMessageTemplate());
    $this->assertEquals(1, $violations->count());

    // Cancel a registration to make room on the wait list.
    $registration->set('state', 'canceled');
    $registration->save();
    $this->assertEquals('canceled', $registration->getState()->id());
    $violations = $registration2->validate();
    $this->assertEquals(0, $violations->count());
    $registration2->save();
    $this->assertEquals('waitlist', $registration2->getState()->id());

    // Make room within standard capacity.
    $active_registration->set('count', 3);
    $active_registration->save();
    $registration2->set('state', 'complete');
    $violations = $registration2->validate();
    $this->assertEquals(0, $violations->count());
    $registration2->save();
    $this->assertEquals('complete', $registration2->getState()->id());

    $registration = $this->createRegistration($node);
    $registration->set('author_uid', 1);
    $violations = $registration->validate();
    $this->assertEquals(0, $violations->count());
    $registration->save();
    // This registration was not wait listed since there
    // was room within standard capacity.
    $this->assertNotEquals('waitlist', $registration->getState()->id());
  }

}
