<?php

namespace Inertia\SSRHead\View\Components;

use Illuminate\View\Component;

class Head extends Component
{
    public function render(): string
    {
        return "<?php echo app(\Inertia\SSRHead\HeadManager::class)->format(4)->render().\"\\n\"; ?>";
    }
}
