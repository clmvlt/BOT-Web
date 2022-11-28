var btn = document.getElementById('ddEmotes');
var loading = document.getElementById('loading');
var img = document.getElementById('img');
var listemotes = document.getElementById('list-emotes');
var rmlist = document.getElementById('rmlist');
var submitrm = document.getElementById('submitrm');
var emotename = document.getElementById('emotename');
const url = basepath+'assets/emojis-names.json';
var emotesName = [];
var rmlistItems = [];

var heads = [
    '&#x1f642', '&#x1F600', '&#x1F602', '&#x1F610', '&#x1F604', '&#x1F606', '&#x1F605', '&#x1F609', '&#x1F60A' ,'&#x1F60C', '&#x1F60D'
];
var ok = true;
img.onmouseenter = () => {
    ok = false;
}
img.onmouseleave = () => {
    ok = true;
}
btn.onmouseover = () => {
    if (!ok) return;
    var rdm = Math.floor(Math.random() * heads.length);
    img.innerHTML = heads[rdm];
    twemoji.parse(document.body);
}

btn.onclick = () => {
    if (listemotes.style.display=='none' || listemotes.style.display=='') {
        listemotes.style.display='block'
    } else {
        listemotes.style.display='none'
    }
}

window.onload = () => {
    fetch(url).then(resp=>{
        return resp.json();
    }).then(json=>{
        emotesName=json;
        var tempInner = "";
        var emoji = Object.keys(emotesName);
        guildEmotes.forEach(e=>{
            tempInner += "<a onclick='add(`"+e.id+"`); show()'><img class='emojiguild' alt='"+e.id+"' src='https://cdn.discordapp.com/emojis/"+e.id+"'></a>";
        });
        tempInner += "<br/><br/>"
        emoji.forEach(e=>{
            tempInner += "<a onclick='add(`"+e+"`); show()'>"+e+"</a>";
        });
        twemoji.parse(document.body);
        loading.innerHTML = '';
        listemotes.innerHTML += tempInner;
    });
    rolesemotes.forEach(rm=>add(rm.emote));
    rmlistRef();
}

function filteremotes() {
    var filter, a, i;
    emotename = document.getElementById('emotename');
    filter = emotename.value.toUpperCase();
    img = listemotes.getElementsByTagName("img");
    for (i = 0; i < img.length; i++) {
        var isFilter = false;
        if (img[i].alt.toUpperCase().indexOf(filter)>-1) isFilter = true;
        var names = emotesName[img[i]?.alt];
        if (names)
            names?.forEach(name=>{
                if (name.toUpperCase().indexOf(filter)>-1) isFilter = true;
            });
        if (isFilter) {
            img[i].style.display='';
        } else {
            img[i].style.display='none';
        }
    }
}

var inList = false;
listemotes.onmouseenter = () => inList = true;
listemotes.onmouseleave = () => inList = false;

function filterFunction(divname, inputname) {
    var input, filter, ul, li, a, i;
    input = document.getElementById(inputname);
    filter = input.value.toUpperCase();
    div = document.getElementById(divname);
    a = div.getElementsByTagName("a");
    for (i = 0; i < a.length; i++) {
        txtValue = a[i].textContent || a[i].innerText;
        if (txtValue.toUpperCase().indexOf(filter) > -1) {
            a[i].style.display = "";
        } else {
            a[i].style.display = "none";
        }
    }
}

document.body.addEventListener("click", function (evt) {
    if (listemotes.style.display=='block') {
        if (!inList && ok) listemotes.style.display='none'
    }
});

function add(e) {
    if (rmlistItems.find(i=>{
        var alt = e;
        if (i.isGuild) alt = "https://cdn.discordapp.com/emojis/"+e;
        return alt==i.alt
    })) {
        return;
    }
    show();
    var isGuild = parseInt(e)>=0;
    var alt = e;
    if (isGuild) alt = "https://cdn.discordapp.com/emojis/"+e;
    rmlistItems.push({
        isGuild: isGuild,
        alt: alt,
        emote: e
    });
    rmlistRef();
}

function addRole(e, roleid) {
    if (rmlistItems.find(i=>i.emote==e)) {
        rolesemotes.push({
            id: -1,
            emote: e,
            roleid: roleid
        });
        rmlistRef();
        show();
    }
}

function removeRole(e, roleid) {
    if (rmlistItems.find(i=>{
        var alt = e;
        if (i.isGuild) alt = "https://cdn.discordapp.com/emojis/"+e;
        return alt==i.alt
    })) {
        var role = rolesemotes.find(x=>x.roleid==roleid&&x.emote==e);
        var i = rolesemotes.indexOf(role);
        if (i>=0) rolesemotes.splice(i, 1);
        rmlistRef();
        show();
    }
}

function remove(e) {
    var isGuild = parseInt(e)>=0;
    var alt = e;
    if (isGuild) alt = "https://cdn.discordapp.com/emojis/"+e;
    var y = rmlistItems.indexOf(rmlistItems.find(x=>x.emote==e));
    if (y>=0) {
        rmlistItems.splice(y, 1);
        rolesemotes.filter(r=>r.emote==e).forEach(r=>{
            var i = rolesemotes.indexOf(r);
            if (i>=0) rolesemotes.splice(i, 1);
        });
    }
    rmlistRef();
    show();
}

function rmlistRef() {
    rmlist.innerHTML = '';
    rmlistItems.forEach(i=>{
        var tempInner = "<div class='p-2' style='background-color: #282A2A; border-radius: 12px'>";
        if (i.isGuild) {
            tempInner += `
            <img src='${i.alt}' alt='${i.alt}' class='${i.isGuild?"emojiguild":"emoji"}'>
            <button class="btn btn-sm btn-outline-danger" onclick='remove("${i.emote}"); show()'>Supprimer</button> 
            `;
            
        } else {
            tempInner += `
            ${i.alt}
            <button class="btn btn-sm btn-outline-danger" onclick='remove("${i.emote}"); show()'>Supprimer</button> 
            `;
        }
        tempInner += `
        <div class='dropdown' style="display:inline-block;">
        `;
        rolesemotes.forEach(rm=>{
            var role = roles.find(r=>r.id==rm.roleid);
            if (!role) return;
            if (rm.emote==i.emote) {
                tempInner +=`
                <span class="p-1 m-1 align-middle" style="background-color: transparent; border-radius: 7px; display: inline-block; border: 1px solid; border-color: ${role.color.toString(16)=="0"?'#FFFFFF':"#"+role.color.toString(16)}">
                <span style="color: ${role.color.toString(16)=="0"?'#FFFFFF':"#"+role.color.toString(16)};">◉ </span>${role.name} <a class="pr-1" style="color: #97A9B4; text-decoration: none;" onclick="removeRole('${rm.emote}', '${role.id}')">×</a></span>
                `;
            }
        });
        tempInner+=`
        <a id="dropdownMenuButton" data-toggle="dropdown" style="cursor: pointer;" aria-haspopup="true" aria-expanded="false"><span class="p-1 m-1 align-middle text-white" style="background-color: #2F3335; border-radius: 7px">+</span></a>
        <div class="dropdown-menu text-white" style="background-color: #2A2D30; color: white" aria-labelledby="dropdownMenuButton" id="ddb${i.alt}">
            <input type="text" style="background-color: #2A2D30; color: white; background-position: 14px 12px; background-repeat: no-repeat; font-size: 16px; padding: 14px; border: none; border-bottom: 1px solid #ddd;" placeholder="Rechercher un rôle" id="myInput${i.alt}" onkeyup="filterFunction('ddb${i.alt}', 'myInput${i.alt}')">
        `;
        var roleids = rolesemotes.filter(r=>r.emote==i.emote);
        roles.forEach(role=>{
            if (roleids.find(x=>x.roleid==role.id) || role?.tags?.bot_id || role?.tags?.premium_subscriber !== undefined || role?.id==guild.id) return;
            tempInner+=`
                <a style="color: ${role.color.toString(16)=="0"?'#FFFFFF':"#"+role.color.toString(16)}" class="dropdown-item" onclick="addRole('${i.emote}', '${role.id}')">${role.name}</a>
            `
        })
        tempInner+='</div></div></div><br/>';
        rmlist.innerHTML += tempInner;
    });
    creation();
    twemoji.parse(document.body);
}

function creation() {
    var tempInner = "";
    rolesemotes.forEach(r => {
        var i = rolesemotes.indexOf(r);
        tempInner += `<input type='hidden' name='rolesemotes[${i}][]' value="${r.emote}"></input>`;
        tempInner += `<input type='hidden' name='rolesemotes[${i}][]' value="${r.roleid}"></input>`;
    });
    submitrm.innerHTML = tempInner;
}