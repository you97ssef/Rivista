import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { environment } from 'src/environments/environment';

@Injectable({
  providedIn: 'root',
})
export class LikeService {
  private api = environment.apiUrl;

  constructor(private http: HttpClient) {}

  like(rivista: any) {
    return this.http.post(`${this.api}/likes`, rivista);
  }

  unlike(rivista: any) {
    return this.http.delete(`${this.api}/likes`, { body: rivista });
  }
}
