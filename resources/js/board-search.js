var boardSearch = {
    links: null,

    search: function(element) {
        const search = element.value.toLowerCase();

        for (const link of this.getLinks()) {
            if (link.dataset.text.toLowerCase().includes(search)) {
                link.classList.remove('hidden');
            } else {
                link.classList.add('hidden');
            }
        }
    },

    getLinks: function () {
        if (this.links !== null) {
            return this.links;
        }

        this.links = document.querySelectorAll('.js-board-link');
        return this.links;
    }
};

export {
    boardSearch as default
};
