import { ajax } from "./ajax.js"
import { getContext } from "./list_getContext.js"

const container = document.querySelector("#content")
const base = container.querySelector(".pair")


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


function populate(data)
{
    clear()

    data.forEach(row => {
        var div = base.cloneNode(true)
        var ctx = getContext(div)
        
        ctx.id = row.id
        ctx.name = row.name
        ctx.count = row.count
        ctx.price = row.price
        ctx.deliver = row.deliver

        container.appendChild(div)
    })
}
