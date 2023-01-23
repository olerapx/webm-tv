class BoardSearch {
    constructor(container) {
        this.container = container;
        this.links = null;
    }

    setElement(element) {
        this.element = element;
    }

    search() {
        const search = this.element.value.toLowerCase();

        for (const link of this._getLinks()) {
            if (link.dataset.text.toLowerCase().includes(search)) {
                link.classList.remove('hidden');
            } else {
                link.classList.add('hidden');
            }
        }
    }

    _getLinks () {
        if (this.links !== null) {
            return this.links;
        }

        this.links = this.container.querySelectorAll('.js-board-link');
        return this.links;
    }
}

window.BoardSearch = BoardSearch;
