function fetchPostsJson(json) {
  console.log(json);
  const ris_ricerca = document.querySelector("#ris_ricerca");
  //console.log(json[0].postid);
  for(let i=0; i<json.length; i++){
    const title = json[i].content.film;
    const username = json[i].username;
    const time = json[i].time;
    const nlikes = json[i].nlikes;

    const f = document.createElement("div");
    f.setAttribute("id", "postid");
    f.classList.add("film");
    
    const img = document.createElement("img");
    img.src = json[i].content.url;
    const head_username = document.createElement("span");
    head_username.setAttribute("id", "username");
    head_username.textContent = username;
    
    const head_time = document.createElement("span");
    head_time.setAttribute("id", "time");
    head_time.textContent = time;
    const caption = document.createElement("span");
    caption.textContent = "Titolo: " + title;
    const like = document.createElement("span");
    like.textContent = nlikes;
    const cuore_v = document.createElement("img");
    cuore_v.setAttribute("id", "cuore_v");
    cuore_v.src = "./cuore_v.jpg";
    f.appendChild(head_username);
    f.appendChild(head_time);
    f.appendChild(img);
    f.appendChild(caption);
    f.appendChild(cuore_v);
    f.appendChild(like);
    ris_ricerca.appendChild(f);

    cuore_v.addEventListener("click", likePost);
  }

}

function fetchLikesJson(json){
  console.log(json);
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

function fetchLikes(){
  fetch("hw1_fetch_likes.php").then(fetchResponse).then(fetchLikesJson);
}


function likePost(event) {
  const button = event.currentTarget;
  const formData = new FormData();

  //const f = document.querySelectorAll('#postid');
  //console.log(f);
  console.log(button.parentNode.parentNode.dataset.postid);
  // prendo l'id del post
  formData.append("postid", button.parentNode.dataset.postid);

  // mando l'id alla pagina php tramite fetch
  fetch("hw1_like_post.php", { method: "post", body: formData })
    .then(fetchResponse)
    .then(function (json) {
      return updateLikes(json, button);
    });

  // cambio la classe del bottone
  button.classList.remove("like");
  button.classList.add("liked");

  // aggiorno i listener
  button.removeEventListener("click", likePost);
  button.addEventListener("click", unlikePost);
}


function unlikePost(event) {
  const button = event.currentTarget;
  const formData = new FormData();

  console.log(button.parentNode.username);
  // prendo l'id del post
  formData.append("postid", button.parentNode.dataset.postid);

  // mando l'id alla pagina php tramite fetch
  fetch("hw1_like_post.php", { method: "post", body: formData })
    .then(fetchResponse)
    .then(function (json) {
      return updateLikes(json, button);
    });

  // cambio la classe del bottone
  button.classList.add("like");
  button.classList.remove("liked");

  // aggiorno i listener
  button.removeEventListener("click", unlikePost);
  button.addEventListener("click", likePost);
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
  const f = document.createElement("div");
  f.classList.add("film");
  const img = document.createElement("img");
  img.src = poster;
  const caption = document.createElement("span");
  caption.textContent = "Titolo: " + title + " - Anno uscita: " + year;
  f.appendChild(img);
  f.appendChild(caption);
  ris_ricerca.appendChild(f);

  //console.log(json);

  const formData = new FormData();
  formData.append("film", document.querySelector("#film").value);
  formData.append("poster", img.src);
  fetch("hw1_post_dispatcher.php", { method: "post", body: formData });

  //window.location.reload();
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
fetchLikes();
