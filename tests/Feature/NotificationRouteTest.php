<?php

namespace Tests\Feature;

use Tests\TestCase;

class NotificationRouteTest extends TestCase
{
    public function test_notification_delete_routes_are_defined_for_all_roles(): void
    {
        $router = app('router');

        $this->assertTrue($router->getRoutes()->hasNamedRoute('super-admin.notifications.delete-all'));
        $this->assertTrue($router->getRoutes()->hasNamedRoute('admin.notifications.delete-all'));
        $this->assertTrue($router->getRoutes()->hasNamedRoute('validator.notifications.delete-all'));
        $this->assertTrue($router->getRoutes()->hasNamedRoute('pengusul.notifications.delete-all'));
        $this->assertTrue($router->getRoutes()->hasNamedRoute('pengusul-desa.notifications.delete-all'));
    }
}
