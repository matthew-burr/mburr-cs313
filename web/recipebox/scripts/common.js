function headers(method, body) {
  return {
    method: method,
    credentials: "same-origin",
    redirect: "follow",
    body: body,
    headers: new Headers({
      "Content-Type": "application/json",
      Accept: "application/json"
    })
  };
}
