import { Inertia } from '@inertiajs/inertia'

export default function updateTitle() {
  const originalTitle = document.title

  function setTitle(value) {
    if (document.title !== value) {
      document.title = value
    }
  }

  Inertia.on('navigate', event => {
    const pageTitle = event.detail.page.props.title
    if (pageTitle) {
      setTitle(pageTitle)
    } else {
      setTitle(originalTitle)
    }
  })
}
