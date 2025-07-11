import { defineStore } from 'pinia'
import axios from 'axios'

const BASE_URL = 'http://127.0.0.1:8000/api/authors'

export const useAuthorStore = defineStore('authorStore', {
  state: () => ({
    authors: [],       // List of authors with metadata
    author: null,      // Single author detail
    loading: false,    // Global loading state
    error: null        // API error message
  }),

  actions: {
    /**
     * Fetch all authors from API
     */
    async fetchAuthors() {
      this.loading = true
      this.error = null

      try {
        const response = await axios.get(BASE_URL)
        this.authors = response.data
      } catch (error) {
        this.handleError(error)
      } finally {
        this.loading = false
      }
    },

    /**
     * Fetch single author by ID
     * @param {number} id 
     */
    async fetchAuthorById(id) {
      this.loading = true
      this.error = null

      try {
        const response = await axios.get(`${BASE_URL}/${id}`)
        this.author = response.data
      } catch (error) {
        this.handleError(error)
      } finally {
        this.loading = false
      }
    },

    /**
     * Create a new author
     * @param {Object} authorData 
     */
    async createAuthor(authorData) {
      this.error = null

      try {
        await axios.post(BASE_URL, authorData)
        await this.fetchAuthors()
      } catch (error) {
        this.handleError(error)
      }
    },

    /**
     * Update an existing author
     * @param {number} id 
     * @param {Object} authorData 
     */
    async updateAuthor(id, authorData) {
      this.error = null

      try {
        await axios.put(`${BASE_URL}/${id}`, authorData)
        await this.fetchAuthors()
      } catch (error) {
        this.handleError(error)
      }
    },

    /**
     * Delete an author by ID
     * @param {number} id 
     */
    async deleteAuthor(id) {
      this.error = null

      try {
        await axios.delete(`${BASE_URL}/${id}`)
        await this.fetchAuthors()
      } catch (error) {
        this.handleError(error)
      }
    },

    /**
     * Handle and normalize API errors
     * @param {Object} error 
     */
    handleError(error) {
      this.error = error?.response?.data?.message || error.message || 'An unexpected error occurred'
      console.error('[AuthorStore Error]:', this.error)
    }
  }
})
