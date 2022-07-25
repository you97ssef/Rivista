import { Component, OnInit } from '@angular/core';
import { CategoryService } from 'src/app/services/category.service';

@Component({
  selector: 'app-home',
  templateUrl: './home.component.html',
  styleUrls: ['./home.component.scss'],
})
export class HomeComponent implements OnInit {
  categories: any = null;
  constructor(private categoryService: CategoryService) {}

  ngOnInit(): void {
    this.categoryService.all().subscribe((response: any) => {
      this.categories = response.data;
      console.log(response);
    });
  }

  isVerified() {
    let user = localStorage.getItem('user');

    if (!user) return true;

    if (JSON.parse(user).email_verified_at) return true;

    return false;
  }
}
