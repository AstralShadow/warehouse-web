import { ajax } from "./ajax.js"
import { getContext } from "./list_getContext.js"

const container = document.querySelector("#content")
const base = container.querySelector(".pair")
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
    if(query === undefined) query = {}
    var req = await ajax("get", "/list/data", query);
    console.log(req, req.data)

    populate(req.data)
}

fetch()


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

function populate(data)
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
}
