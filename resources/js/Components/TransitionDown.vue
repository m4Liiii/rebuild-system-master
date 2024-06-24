<template>
    <transition
    enter-active-class="enter-active-class"
    enter-from-class="enter-from-class"
    enter-to-class="enter-to-class"
    leave-active-class="leave-active-class"
    leave-from-class="leave-from-class"
    leave-to-class="leave-to-class"
  >

    <slot />
</transition>

</template>
<style>
/* Default styles for large screens */
.enter-active-class,
.leave-active-class {
  transition: transform 250ms ease-in-out;
}

.enter-from-class {
  transform: translateX(-200%);
}

.enter-to-class,
.leave-from-class {
  transform: translateX(0);
}

.leave-to-class {
  transform: translateX(-200%);
}

/* Styles for mobile */
@media (max-width: 640px) {
  .enter-from-class {
    transform: translateX(200%);
  }

  .leave-to-class {
    transform: translateX(200%);
  }
}
</style>
