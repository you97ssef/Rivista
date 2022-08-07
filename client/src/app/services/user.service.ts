import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { environment } from 'src/environments/environment';

@Injectable({
  providedIn: 'root',
})
export class UserService {
  private api = environment.apiUrl;

  constructor(private http: HttpClient) {}

  all() {
    return this.http.get(`${this.api}/users`);
  }
  
  allByLikes() {
    return this.http.get(`${this.api}/likes/users`);
  }

  allByViews() {
    return this.http.get(`${this.api}/views/users`);
  }

  get(slug: string) {
    return this.http.get(`${this.api}/users/${slug}`);
  }

  update(data: any) {
    return this.http.put(`${this.api}/user`, data);
  }

  delete(data: any) {
    return this.http.delete(`${this.api}/user`, { body: data });
  }

  changeRole(user: any) {
    return this.http.put(`${this.api}/user-role`, user);
  }
}
