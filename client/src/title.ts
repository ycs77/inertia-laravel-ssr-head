import { router } from '@inertiajs/core'

export function setTitle(value: string) {
  if (typeof document === 'undefined') return

  setTimeout(() => document.title = value, 1)
}

export function inertiaTitle(): void {
  if (typeof document === 'undefined') return

  router.on('navigate', event => {
    const title = event.detail.page.props.title as string
    setTitle(title)
  })
}

export function useInertiaTitle(): void {
  inertiaTitle()
}
