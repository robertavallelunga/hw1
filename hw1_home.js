function fetchPostsJson(json) {
  const ris_ricerca = document.querySelector("#ris_ricerca");
    
  for(let i=0; i<json.length; i++){
    const title = json[i].content.film;
    const username = json[i].username;
    const time = json[i].time;
    const nlikes = json[i].nlikes;

    const f = document.createElement("div");
    f.setAttribute("id", json[i].postid);
    f.setAttribute("liked", json[i].liked);
    f.classList.add("film");

    const head = document.createElement("div");
    head.setAttribute("id", "head");
    head.classList.add("orizzontale");
    const img = document.createElement("img");
    img.src = json[i].content.url;
    const head_username = document.createElement("span");
    head_username.setAttribute("id", "username");
    head_username.textContent = username;
    const head_time = document.createElement("span");
    head_time.setAttribute("id", "time");
    head_time.setAttribute("align", "right");
    head_time.textContent = time;
    head.appendChild(head_username);
    head.appendChild(head_time);
    f.appendChild(head);

    const caption = document.createElement("span");
    caption.setAttribute("id", "titolo");
    caption.textContent = "Titolo: " + title.toUpperCase();
    f.appendChild(img);
    f.appendChild(caption);

    const nlike = document.createElement("span");
    nlike.setAttribute("id", "nlikes");
    nlike.textContent = nlikes;

    const like = document.createElement("div");
    like.setAttribute("id", "like");
    like.classList.add("like");
    
    const cuore_p = document.createElement("img");
    cuore_p.setAttribute("id", "cuore_p");
    const cuore_v = document.createElement("img");
    cuore_v.setAttribute("id", "cuore_v");
    cuore_v.src="./cuore_v.png";
    cuore_p.src="./cuore_p.png";
    
    if (json[i].liked == 1) {
      cuore_v.classList.add("nasosto");
      like.appendChild(cuore_p);
    }
    else{
      cuore_p.classList.add("nasosto");
      like.appendChild(cuore_v);
    }
    
    like.appendChild(nlike);
    f.appendChild(like);

    ris_ricerca.appendChild(f);

    cuore_v.addEventListener("click", likePost);
    cuore_p.addEventListener("click", unlikePost);
  }
}

function fetchResponse(response) {
  if (!response.ok) {
    return null;
  }
  return response.json();
}

function fetchPosts(){
        fetch("hw1_fetch_post.php").then(fetchResponse).then(fetchPostsJson); 
}

function updateLikes(json, button){ 
  button.classList.add("nascosto");
  if (button.parentNode.childNodes[0].id == "cuore_v") { 
    console.log(json);
    button.parentNode.childNodes[0].src = "./cuore_p.png";
    button.parentNode.childNodes[0].id = "cuore_p";
    button.parentNode.childNodes[0].classList.remove("nascosto");
    console.log(button.parentNode);
  }
  else {
    console.log(json);
    button.parentNode.childNodes[0].src = "./cuore_v.png";
    button.parentNode.childNodes[0].id = "cuore_v";
    button.parentNode.childNodes[0].classList.remove("nascosto");
    console.log(button.parentNode);
  }

  button.parentNode.parentNode.childNodes[3].lastChild.innerHTML = json.nlikes;
}

function unlikePost (event) {
  const button = event.currentTarget;
  const formData = new FormData();
  // prendo l'id del post
  formData.append("postid", button.parentNode.parentNode.id);
  // mando l'id alla pagina php tramite fetch
 fetch("hw1_unlike_post.php", { method: "post", body: formData })
    .then(fetchResponse)
    .then(function (json) {
      return updateLikes(json, button);
    });

  // aggiorno i listener
  button.addEventListener("click", likePost);
  button.removeEventListener("click", unlikePost);
}

function likePost(event) {
  const button = event.currentTarget;
  const formData = new FormData();
  // prendo l'id del post
  formData.append("postid", button.parentNode.parentNode.id);

  // mando l'id alla pagina php tramite fetch
 fetch("hw1_like_post.php", { method: "post", body: formData })
    .then(fetchResponse)
    .then(function (json) {
      return updateLikes(json, button);
    });

  // aggiorno i listener
  button.removeEventListener("click", likePost);
  button.addEventListener("click", unlikePost);
}

function search_f(event) {
  event.preventDefault(); //impedisce il submit del form
  //leggi valore del campo di testo
  const film_input = document.querySelector("#film");
  const film_value = encodeURIComponent(film_input.value);
  rest_url = "http://www.omdbapi.com/?apikey=ae2d3f84&s=" + film_value;
  document.querySelector("#films").classList.add("nascosto");
  //esegui fetch
  fetch(rest_url).then(onResponse).then(onJson);
}

function onResponse(response) {
  return response.json();
}

function onJson(json) {
  const ris_ricerca = document.querySelector("#ris_ricerca");
  const film = json.Search[0];
  const title = film.Title;
  const year = film.Year;
  const poster = film.Poster;
  const nlikes = film.nlikes;
  const f = document.createElement("div");
  f.classList.add("film");
  const img = document.createElement("img");
  img.src = poster;
  const caption = document.createElement("span");
  caption.textContent = "Titolo: " + title + " - Anno uscita: " + year;
  f.appendChild(img);
  f.appendChild(caption);

  ris_ricerca.appendChild(f);

  const formData = new FormData();
  formData.append("film", document.querySelector("#film").value);
  formData.append("poster", img.src);
  fetch("hw1_post_dispatcher.php", { method: "post", body: formData });
}

function Post() {
  const form_f = document.querySelector("#films");
  form_f.classList.remove("nascosto");
  form_f.addEventListener("submit", search_f);
}


document.querySelector("#films").classList.add("nascosto");
document.querySelector(".post").addEventListener("click", Post);
let lastFetchedPostId = null;
fetchPosts();
