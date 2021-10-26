import { Inertia } from '@inertiajs/inertia'

export function useInertiaTitle(): void {
  function setTitle(value: string) {
    setTimeout(() => document.title = value, 1)
  }

  Inertia.on('navigate', event => {
    const title = event.detail.page.props.title as string
    setTitle(title)
  })
}
