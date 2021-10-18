import { Inertia } from '@inertiajs/inertia'

export function useInertiaTitle(): void {
  const originalTitle = document.title

  function setTitle(value: string) {
    if (document.title !== value) {
      setTimeout(() => document.title = value, 1)
    }
  }

  Inertia.on('navigate', event => {
    const title = event.detail.page.props.title as string
    setTitle(title || originalTitle)
  })
}
