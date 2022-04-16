import { ajax } from "./ajax.js"
import { getContext } from "./list_getContext.js"

const container = document.querySelector("#content")
const base = container.querySelector(".pair")
const search_bar = document.querySelector("#search_bar")
const search_btn = document.querySelector(".search")
const elements = []

function clear()
{
    while(container.firstChild)
        container.removeChild(container.firstChild)
    // This always feels kinda cursed when i type it.
}

clear()


async function fetch(query)
{
    var data = null
    if(query != undefined)
    {
        data = new FormData()
        data.append("search", query)
    }

    var url = "/list/data"
    var req = await ajax("post", url, data)

    populate(req.data, query)
}

fetch(search_bar.value)


function toggleFocus(pair) {
    if(pair.classList.contains("focus"))
    {
        pair.classList.remove("focus")
    }
    else
    {
        elements.forEach(other => {
            // Uncomment to allow only one focused element
            //other.classList.remove("focus")
        })

        pair.classList.add("focus")
    }
}

function populate(data, query)
{
    clear()
    elements.length = 0

    data.forEach(row => {
        var div = base.cloneNode(true)
        div.querySelector(".row").onclick = 
            () => toggleFocus(div)
        
        var ctx = getContext(div)
        
        ctx.id = row.id
        ctx.name = row.name
        ctx.count = row.count
        ctx.price = row.price
        ctx.deliver = row.deliver
        ctx.date = row.date

        container.appendChild(div)
        elements.push(div)
    })

    if(data.length == 0)
    {
        var msg = document.createElement("p")
        msg.classList.add("info")
        if(query)
            msg.innerText = "Няма намерени доставки," + 
                " които отговарят на търсенето " +
                '"' + query + '"'
        else
            msg.innerText = "Няма налични доставки. " +
                "Можете да добавите такива от бутона " +
                "Нова доставка."
        container.appendChild(msg)
    }
}


/* Search bar */

search_btn.addEventListener('click', function()
{
    var value = search_bar.value
    fetch(value)
})

search_bar.addEventListener('blur', function()
{
    var value = search_bar.value
    fetch(value)
})

search_bar.addEventListener('keydown', function(e)
{
    if(e.keyCode != 13) return;
    var value = search_bar.value
    fetch(value)
})
