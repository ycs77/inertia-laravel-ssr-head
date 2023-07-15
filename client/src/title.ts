import { router } from '@inertiajs/core'

export function useInertiaTitle(): void {
  if (typeof document === 'undefined') return

  function setTitle(value: string) {
    setTimeout(() => document.title = value, 1)
  }

  router.on('navigate', event => {
    const title = event.detail.page.props.title as string
    setTitle(title)
  })
}
