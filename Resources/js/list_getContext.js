
export function getContext(base)
{
    var name = base.querySelector(".name")
    var count = base.querySelector(".count")
    var price = base.querySelector(".price")
    var edit = base.querySelector(".edit")
    var remove  = base.querySelector(".delete") // keyword
    var deliver = base.querySelector(".deliver")
    var date = base.querySelector(".date")
    var id = undefined

    return {
        get name()
            { return name.innerText },
        set name(v)
            { name.innerText = v },

        get count()
            { return count.innerText },
        set count(v)
            { count.innerText = v },

        get price()
            { return parseFloat(price.innerText) },
        set price(v)
            { price.innerText = parseFloat(v) + "лв" },

        get id()
            { return id },
        set id(v)
        {
            id = v
            ;[edit, remove].forEach(btn => {
                var url = btn.getAttribute("data-href")
                       + "?id=" + id
                btn.href = url
            })
        },

        get deliver()
            { return deliver.innerText },
        set deliver(v)
            { deliver.innerText = v }
    }
}

