<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * TicketsFixture
 */
class TicketsFixture extends TestFixture
{
    /**
     * Init method
     *
     * @return void
     */
    public function init(): void
    {
        $this->records = [
            [
                'id' => 1,
                'subject' => 'Lorem ipsum dolor sit amet',
                'customer_name' => 'Lorem ipsum dolor sit amet',
                'customer_email' => 'Lorem ipsum dolor sit amet',
                'message' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
                'priority' => 'Lorem ipsum dolor ',
                'status' => 'Lorem ipsum dolor sit amet',
                'attachment' => 'Lorem ipsum dolor sit amet',
                'created' => '2026-10-13 15:13:11',
                'modified' => '2026-10-13 15:13:11',
            ],
        ];
        parent::init();
    }
}
