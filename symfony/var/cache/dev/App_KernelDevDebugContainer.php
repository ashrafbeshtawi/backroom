<?php

// This file has been auto-generated by the Symfony Dependency Injection Component for internal use.

if (\class_exists(\ContainerXz7o9xe\App_KernelDevDebugContainer::class, false)) {
    // no-op
} elseif (!include __DIR__.'/ContainerXz7o9xe/App_KernelDevDebugContainer.php') {
    touch(__DIR__.'/ContainerXz7o9xe.legacy');

    return;
}

if (!\class_exists(App_KernelDevDebugContainer::class, false)) {
    \class_alias(\ContainerXz7o9xe\App_KernelDevDebugContainer::class, App_KernelDevDebugContainer::class, false);
}

return new \ContainerXz7o9xe\App_KernelDevDebugContainer([
    'container.build_hash' => 'Xz7o9xe',
    'container.build_id' => '624a1c6a',
    'container.build_time' => 1677363732,
], __DIR__.\DIRECTORY_SEPARATOR.'ContainerXz7o9xe');