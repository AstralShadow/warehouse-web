document.querySelectorAll("[data-value]")
    .forEach(e => {
        if(e.getAttribute("data-value") == "now")
            {
                e.value = new Date()
                    .toISOString()
                    .split('T')[0]
            }
    }
)
