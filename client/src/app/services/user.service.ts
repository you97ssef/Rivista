import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { environment } from 'src/environments/environment';

@Injectable({
  providedIn: 'root'
})
export class UserService {
  private api = environment.apiUrl;

  constructor(private http: HttpClient) {}

  all(){
    return this.http.get(`${this.api}/users`);
  }

  get(slug: string){
    return this.http.get(`${this.api}/users/${slug}`);
  }
}
